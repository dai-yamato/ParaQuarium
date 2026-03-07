<?php

namespace App\Livewire;

use App\Models\Tank;
use App\Models\MaintenanceLog;
use App\Models\WaterParameter;
use App\Services\WaterParameterService;
use Carbon\Carbon;
use Livewire\Component;

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
    public $w_ph;
    public $w_temp;
    public $w_nitrite;
    public $w_gh;
    public $w_measured_at;
    
    // Maintenance Log Form
    public $m_action;
    public $m_description;
    public $m_date;

    public function mount()
    {
        $this->loadTanks();
        $this->w_measured_at = now()->timezone('Asia/Tokyo')->format('Y-m-d\TH:i');
        $this->m_date = now()->timezone('Asia/Tokyo')->format('Y-m-d');
        
        if ($this->tanks->isNotEmpty()) {
            $this->selectedTankId = $this->tanks->first()->id;
        }
    }

    public function loadTanks()
    {
        $this->tanks = Tank::all();
    }

    public function selectTank($id)
    {
        $this->selectedTankId = $id;
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

    public function saveWaterParameters(WaterParameterService $service)
    {
        if (!$this->selectedTankId) return;

        try {
            $service->recordParameters($this->selectedTankId, [
                'ph' => $this->w_ph !== '' ? $this->w_ph : null,
                'temperature' => $this->w_temp !== '' ? $this->w_temp : null,
                'nitrite' => $this->w_nitrite !== '' ? $this->w_nitrite : null,
                'gh' => $this->w_gh !== '' ? $this->w_gh : null,
                'measured_at' => $this->w_measured_at,
            ]);

            session()->flash('w_message', '水質データを記録しました。');
            $this->reset(['w_ph', 'w_temp', 'w_nitrite', 'w_gh']);
            $this->w_measured_at = now()->timezone('Asia/Tokyo')->format('Y-m-d\TH:i');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->errors());
        }
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
        if (!$this->selectedTankId) return null;
        return WaterParameter::where('tank_id', $this->selectedTankId)
            ->orderBy('measured_at', 'desc')
            ->first();
    }

    public function getHistoryParametersProperty()
    {
        if (!$this->selectedTankId) return [];
        return WaterParameter::where('tank_id', $this->selectedTankId)
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

    public function render()
    {
        return view('livewire.dashboard')->layout('components.layouts.app');
    }
}
