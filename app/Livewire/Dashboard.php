<?php

namespace App\Livewire;

use App\Models\Tank;
use App\Models\MaintenanceLog;
use App\Models\WaterRecord;
use App\Models\WaterRecordValue;
use App\Models\ParameterType;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $tanks;
    public $selectedTankId = null;
    
    // Tank Form
    public $isAddingTank = false;
    public $isEditingTank = false;
    public $tankName;
    public $tankVolume;
    public $tankType = 'freshwater';
    
    // Water Parameter Form
    public $w_measured_at;
    public $w_values = []; // parameter_type_id => value
    public $parameterTypes = [];
    
    // Custom Parameter Type Form
    public $newParamName;
    public $newParamUnit;
    
    // Maintenance Log Form
    public $m_action;
    public $m_description;
    public $m_date;

    // Chart Data
    public array $chartData = ['categories' => [], 'series' => []];

    public function mount()
    {
        $this->loadTanks();
        $this->loadParameterTypes();
        $this->w_measured_at = now()->timezone('Asia/Tokyo')->format('Y-m-d\TH:i');
        $this->m_date = now()->timezone('Asia/Tokyo')->format('Y-m-d');
        
        if ($this->tanks->isNotEmpty()) {
            $this->selectedTankId = $this->tanks->first()->id;
        }

        $this->updateChartData();
    }

    public function loadTanks()
    {
        $this->tanks = Tank::all();
    }
    
    public function loadParameterTypes()
    {
        $userId = Auth::id();
        $this->parameterTypes = ParameterType::whereNull('user_id')
            ->orWhere('user_id', $userId)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
            
        // Initialize form values
        foreach ($this->parameterTypes as $type) {
            if (!array_key_exists($type->id, $this->w_values)) {
                $this->w_values[$type->id] = '';
            }
        }
    }

    public function selectTank($id)
    {
        $this->selectedTankId = $id;
        $this->updateChartData();
    }

    public function showAddTankForm()
    {
        $this->reset(['tankName', 'tankVolume', 'tankType']);
        $this->isEditingTank = false;
        $this->isAddingTank = true;
    }

    public function editTank()
    {
        $tank = $this->selectedTank;
        if ($tank) {
            $this->tankName = $tank->name;
            $this->tankVolume = $tank->volume;
            $this->tankType = $tank->type;
            $this->isEditingTank = true;
            $this->isAddingTank = true;
        }
    }

    public function saveTank()
    {
        $this->validate([
            'tankName' => 'required|string|max:255',
            'tankVolume' => 'required|numeric|min:0',
            'tankType' => 'required|in:freshwater,saltwater',
        ], [
            'tankName.required' => '名前を入力してください',
            'tankName.max' => '名前は255文字以内で入力してください',
            'tankVolume.required' => '水量を入力してください',
            'tankVolume.numeric' => '水量は数値で入力してください',
            'tankVolume.min' => '水量は0以上で入力してください',
            'tankType.required' => 'タイプを選択してください',
            'tankType.in' => '正しいタイプを選択してください',
        ]);

        if ($this->isEditingTank && $this->selectedTankId) {
            $tank = Tank::find($this->selectedTankId);
            $tank->update([
                'name' => $this->tankName,
                'volume' => $this->tankVolume,
                'type' => $this->tankType,
            ]);
        } else {
            $tank = Tank::create([
                'name' => $this->tankName,
                'volume' => $this->tankVolume,
                'type' => $this->tankType,
            ]);
            $this->selectedTankId = $tank->id;
        }

        $this->isAddingTank = false;
        $this->isEditingTank = false;
        $this->reset(['tankName', 'tankVolume', 'tankType']);
        $this->loadTanks();
    }
    
    public function saveCustomParameter()
    {
        $this->validate([
            'newParamName' => 'required|string|max:50',
            'newParamUnit' => 'nullable|string|max:20',
        ], [
            'newParamName.required' => '項目名は必須です',
            'newParamName.max' => '50文字以内で入力してください',
            'newParamUnit.max' => '20文字以内で入力してください',
        ]);
        
        ParameterType::create([
            'user_id' => Auth::id(),
            'name' => $this->newParamName,
            'unit' => $this->newParamUnit,
            'icon' => 'activity',
            'sort_order' => 100,
            'is_default' => false,
        ]);
        
        $this->reset(['newParamName', 'newParamUnit']);
        $this->loadParameterTypes();
        session()->flash('param_message', '項目を追加しました。');
    }
    
    public function addPresetParameter($index)
    {
        $preset = $this->presetParameters[$index] ?? null;
        if (!$preset) return;

        // Check if user already has this parameter
        $exists = ParameterType::where(function($q) {
                $q->whereNull('user_id')->orWhere('user_id', Auth::id());
            })
            ->where('name', $preset['name'])
            ->exists();
            
        if ($exists) {
            session()->flash('param_message', 'その項目はすでに追加されています。');
            return;
        }

        ParameterType::create([
            'user_id' => Auth::id(),
            'name' => $preset['name'],
            'unit' => $preset['unit'],
            'icon' => $preset['icon'],
            'sort_order' => 50,
            'is_default' => false,
        ]);
        
        $this->loadParameterTypes();
        session()->flash('param_message', "「{$preset['name']}」を追加しました。");
    }

    public function saveWaterParameters()
    {
        if (!$this->selectedTankId) return;

        $rules = [
            'w_measured_at' => 'required|date',
        ];
        $messages = [
            'w_measured_at.required' => '測定日時は必須です',
            'w_measured_at.date' => '正しい日付を入力してください',
        ];
        
        foreach ($this->parameterTypes as $type) {
            $rules["w_values.{$type->id}"] = 'nullable|numeric';
            $messages["w_values.{$type->id}.numeric"] = "{$type->name}は数値で入力してください";
        }

        $this->validate($rules, $messages);
        
        $record = WaterRecord::create([
            'tank_id' => $this->selectedTankId,
            'measured_at' => $this->w_measured_at,
        ]);
        
        foreach ($this->parameterTypes as $type) {
            $val = $this->w_values[$type->id] ?? '';
            if ($val !== '') {
                WaterRecordValue::create([
                    'water_record_id' => $record->id,
                    'parameter_type_id' => $type->id,
                    'value' => $val,
                ]);
            }
        }

        session()->flash('w_message', '水質データを記録しました。');
        
        // Reset values
        foreach ($this->parameterTypes as $type) {
            $this->w_values[$type->id] = '';
        }
        $this->w_measured_at = now()->timezone('Asia/Tokyo')->format('Y-m-d\TH:i');
    }

    public function saveMaintenanceLog()
    {
        if (!$this->selectedTankId) return;

        $this->validate([
            'm_action' => 'required|string|max:255',
            'm_date' => 'required|date',
        ], [
            'm_action.required' => '作業内容を選択してください',
            'm_action.max' => '作業内容は255文字以内で入力してください',
            'm_date.required' => '実施日を入力してください',
            'm_date.date' => '正しい日付を入力してください',
        ]);

        MaintenanceLog::create([
            'tank_id' => $this->selectedTankId,
            'action' => $this->m_action,
            'description' => $this->m_description,
            'date' => $this->m_date,
        ]);

        session()->flash('m_message', 'メンテナンスログを記録しました。');
        $this->reset(['m_action', 'm_description']);
    }

    public function getSelectedTankProperty()
    {
        if (!$this->selectedTankId) return null;
        return Tank::find($this->selectedTankId);
    }

    public function getLatestParametersProperty()
    {
        if (!$this->selectedTankId) return [];
        $latestRecord = WaterRecord::where('tank_id', $this->selectedTankId)
            ->orderBy('measured_at', 'desc')
            ->first();
            
        if (!$latestRecord) return [];
        
        return $latestRecord->values->mapWithKeys(function ($val) {
            return [$val->parameter_type_id => $val->value];
        })->toArray();
    }

    public function updateChartData()
    {
        if (!$this->selectedTankId) {
            $this->chartData = ['categories' => [], 'series' => []];
            return;
        }

        $records = \App\Models\WaterRecord::with('values.parameterType')
            ->where('tank_id', $this->selectedTankId)
            ->orderBy('measured_at', 'asc') // Sort ascending for charts
            ->get();

        // Limit to latest 15 records to keep chart readable
        if ($records->count() > 15) {
            $records = $records->slice(-15)->values();
        }

        $categories = $records->map(function ($record) {
            return $record->measured_at->format('m/d H:i');
        })->toArray();

        $series = [];
        foreach ($this->parameterTypes as $type) {
            $data = $records->map(function ($record) use ($type) {
                $valModel = $record->values->firstWhere('parameter_type_id', $type->id);
                return $valModel && $valModel->value !== null ? (float)$valModel->value : null;
            })->toArray();
            
            // Only include the series if it has at least one non-null value
            if (count(array_filter($data, fn($v) => $v !== null)) > 0) {
                $series[] = [
                    'name' => $type->name,
                    'data' => $data
                ];
            }
        }

        $this->chartData = ['categories' => $categories, 'series' => $series];
    }

    public function getHistoryParametersProperty()
    {
        if (!$this->selectedTankId) return [];
        return WaterRecord::with('values.parameterType')
            ->where('tank_id', $this->selectedTankId)
            ->orderBy('measured_at', 'desc')
            ->take(10)
            ->get();
    }

    public function getMaintenanceHistoryProperty()
    {
        if (!$this->selectedTankId) return [];
        return MaintenanceLog::where('tank_id', $this->selectedTankId)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();
    }

    public function getPresetParametersProperty()
    {
        return [
            ['name' => '水温', 'unit' => '℃', 'icon' => 'thermometer'],
            ['name' => 'pH', 'unit' => '', 'icon' => 'test-tube-2'],
            ['name' => '総硬度 (GH)', 'unit' => '°dH', 'icon' => 'droplet'],
            ['name' => '炭酸硬度 (KH)', 'unit' => '°dH', 'icon' => 'droplet'],
            ['name' => 'アンモニア (NH3)', 'unit' => 'mg/L', 'icon' => 'alert-circle'],
            ['name' => '亜硝酸 (NO2)', 'unit' => 'mg/L', 'icon' => 'alert-triangle'],
            ['name' => '硝酸塩 (NO3)', 'unit' => 'mg/L', 'icon' => 'activity'],
            ['name' => '比重 / 塩分濃度', 'unit' => '-', 'icon' => 'waves'],
        ];
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('components.layouts.app');
    }
}
