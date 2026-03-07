<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    <!-- Left Sidebar: Tank Management -->
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 p-r relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-cyan-50 to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="relative z-10 flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold flex items-center gap-2 text-slate-800">
                    <i data-lucide="container" class="w-5 h-5 text-cyan-600"></i> 水槽一覧
                </h2>
                <button wire:click="showAddTankForm" class="p-1.5 hover:bg-cyan-100 rounded-lg text-cyan-600 transition-colors">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                </button>
            </div>

            @if($isAddingTank)
            <div class="relative z-10 bg-slate-50 p-4 rounded-xl border border-slate-200 mb-4 animate-fade-in text-sm">
                <form wire:submit.prevent="saveTank" class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">名前</label>
                        <input type="text" wire:model="tankName" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm px-3 py-2 border" placeholder="例: リビングの海水槽">
                        @error('tankName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">水量 (L)</label>
                            <input type="number" step="0.1" wire:model="tankVolume" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm px-3 py-2 border">
                            @error('tankVolume') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">タイプ</label>
                            <select wire:model="tankType" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm px-3 py-2 border">
                                <option value="freshwater">淡水</option>
                                <option value="saltwater">海水</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end pt-2 gap-2">
                        @if($isEditingTank)
                            <button type="button" wire:click="$set('isAddingTank', false)" class="text-slate-500 hover:text-slate-700 px-3 py-2 text-sm font-medium">キャンセル</button>
                        @endif
                        <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors w-full shadow-sm hover:shadow-md outline-none focus:ring-2 focus:ring-offset-1 focus:ring-cyan-500">{{ $isEditingTank ? '水槽を更新' : '水槽を追加' }}</button>
                    </div>
                </form>
            </div>
            @endif

            <div class="space-y-2 relative z-10">
                @forelse($tanks as $tank)
                <button wire:click="selectTank({{ $tank->id }})" class="w-full text-left p-3 rounded-xl border transition-all duration-200 flex items-center justify-between group/btn {{ $selectedTankId == $tank->id ? 'bg-cyan-50 border-cyan-200 ring-1 ring-cyan-200' : 'bg-white border-transparent hover:border-slate-200 hover:bg-slate-50' }}">
                    <div>
                        <div class="font-semibold text-sm {{ $selectedTankId == $tank->id ? 'text-cyan-800' : 'text-slate-700' }}">{{ $tank->name }}</div>
                        <div class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                            <i data-lucide="{{ $tank->type === 'saltwater' ? 'waves' : 'droplets' }}" class="w-3 h-3"></i>
                            {{ $tank->volume }}L &bull; {{ $tank->type === 'freshwater' ? '淡水' : '海水' }}
                        </div>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 {{ $selectedTankId == $tank->id ? 'text-cyan-600' : 'text-slate-300 group-hover/btn:text-slate-400' }} transition-colors"></i>
                </button>
                @empty
                    <div class="text-sm text-slate-500 italic text-center py-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">水槽がまだ登録されていません。</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Main Workspace -->
    <div class="lg:col-span-3 space-y-6">
        @if(!$selectedTankId)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center flex flex-col items-center justify-center min-h-[400px]">
            <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mb-4 text-cyan-600">
                <i data-lucide="fish" class="w-8 h-8"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">ParaQuariumへようこそ</h3>
            <p class="text-slate-500 max-w-sm mb-6">サイドバーから水槽を選択するか、新しく追加して水質データやメンテナンス記録を始めましょう。</p>
            <button wire:click="showAddTankForm" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i> 最初の水槽を追加する
            </button>
        </div>
        @else
        <!-- Header stats for selected tank -->
        @php
            $latest = $this->latestParameters;
            $tank = $this->selectedTank;
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between group hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-medium text-slate-500">ステータス</span>
                    <button wire:click="editTank" class="p-1 hover:bg-slate-100 rounded text-slate-400 hover:text-cyan-600 transition-colors" title="水槽を編集">
                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                    </button>
                    <!-- <i data-lucide="activity" class="w-5 h-5 text-emerald-500"></i> -->
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $tank->name }}</div>
                    <div class="text-sm text-slate-500 mt-1">{{ $tank->type === 'freshwater' ? '淡水' : '海水' }}</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between group hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-50 rounded-full opacity-50 pointer-events-none group-hover:scale-110 transition-transform"></div>
                <div class="flex items-center justify-between mb-2 relative z-10">
                    <span class="text-sm font-medium text-slate-500">水温</span>
                    <i data-lucide="thermometer" class="w-5 h-5 text-red-500"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex items-end gap-1">
                        <span class="text-3xl font-bold text-slate-800">{{ $latest && $latest->temperature !== null ? $latest->temperature : '--' }}</span>
                        <span class="text-sm text-slate-500 mb-1 font-medium">&deg;C</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between group hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-cyan-50 rounded-full opacity-50 pointer-events-none group-hover:scale-110 transition-transform"></div>
                <div class="flex items-center justify-between mb-2 relative z-10">
                    <span class="text-sm font-medium text-slate-500">pH</span>
                    <i data-lucide="test-tube-2" class="w-5 h-5 text-cyan-500"></i>
                </div>
                <div class="relative z-10">
                    <div class="text-3xl font-bold text-slate-800">{{ $latest && $latest->ph !== null ? $latest->ph : '--' }}</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between group hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-orange-50 rounded-full opacity-50 pointer-events-none group-hover:scale-110 transition-transform"></div>
                <div class="flex items-center justify-between mb-2 relative z-10">
                    <span class="text-sm font-medium text-slate-500">亜硝酸 (NO2)</span>
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-orange-500"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex items-end gap-1">
                        <span class="text-3xl font-bold text-slate-800">{{ $latest && $latest->nitrite !== null ? $latest->nitrite : '--' }}</span>
                        <span class="text-sm text-slate-500 mb-1 font-medium">ppm</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between group hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-50 rounded-full opacity-50 pointer-events-none group-hover:scale-110 transition-transform"></div>
                <div class="flex items-center justify-between mb-2 relative z-10">
                    <span class="text-sm font-medium text-slate-500">総硬度 (GH)</span>
                    <i data-lucide="droplet" class="w-5 h-5 text-purple-500"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex items-end gap-1">
                        <span class="text-3xl font-bold text-slate-800">{{ $latest && $latest->gh !== null ? $latest->gh : '--' }}</span>
                        <span class="text-sm text-slate-500 mb-1 font-medium">&deg;dH</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Record Parameters Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="test-tubes" class="w-5 h-5 text-cyan-600"></i> 水質データを記録
                </h3>
                
                @if (session()->has('w_message'))
                    <div class="bg-emerald-50 text-emerald-700 p-3 rounded-lg text-sm mb-4 border border-emerald-100 flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ session('w_message') }}
                    </div>
                @endif
                
                <form wire:submit.prevent="saveWaterParameters" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">水温 (°C)</label>
                            <input type="number" step="0.1" wire:model="w_temp" placeholder="例: 25.5" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 border px-3 py-2 shadow-sm transition-colors text-sm">
                            @error('w_temp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">pH (0-14)</label>
                            <input type="number" step="0.01" wire:model="w_ph" placeholder="例: 7.2" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 border px-3 py-2 shadow-sm transition-colors text-sm">
                            @error('w_ph') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">亜硝酸 (ppm)</label>
                            <input type="number" step="0.01" wire:model="w_nitrite" placeholder="例: 0.0" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 border px-3 py-2 shadow-sm transition-colors text-sm">
                            @error('w_nitrite') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">総硬度 (GH)</label>
                            <input type="number" step="0.1" wire:model="w_gh" placeholder="例: 4.0" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 border px-3 py-2 shadow-sm transition-colors text-sm">
                            @error('w_gh') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">測定日時</label>
                        <input type="datetime-local" wire:model="w_measured_at" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 border px-3 py-2 shadow-sm transition-colors text-sm bg-slate-50 cursor-pointer">
                        @error('w_measured_at') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-2.5 px-4 rounded-xl transition-all shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 flex justify-center items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i> 記録を保存
                        </button>
                    </div>
                </form>
            </div>

            <!-- Maintenance Log Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="clipboard-list" class="w-5 h-5 text-indigo-500"></i> メンテナンスログ
                </h3>
                
                @if (session()->has('m_message'))
                    <div class="bg-indigo-50 text-indigo-700 p-3 rounded-lg text-sm mb-4 border border-indigo-100 flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ session('m_message') }}
                    </div>
                @endif
                
                <form wire:submit.prevent="saveMaintenanceLog" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">作業内容</label>
                        <select wire:model="m_action" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 border px-3 py-2 shadow-sm transition-colors text-sm">
                            <option value="">選択してください...</option>
                            <option value="水換え">水換え</option>
                            <option value="フィルター掃除">フィルター掃除</option>
                            <option value="ガラス掃除">ガラス掃除</option>
                            <option value="薬浴・治療">薬浴・治療</option>
                            <option value="その他">その他</option>
                        </select>
                        @error('m_action') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">実施日</label>
                        <input type="date" wire:model="m_date" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 border px-3 py-2 shadow-sm transition-colors text-sm bg-slate-50 cursor-pointer">
                        @error('m_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">メモ（任意）</label>
                        <textarea wire:model="m_description" rows="2" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 border px-3 py-2 shadow-sm transition-colors text-sm placeholder-slate-400" placeholder="例: 30%水換え、プレフィルター交換など..."></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-medium py-2.5 px-4 rounded-xl transition-all shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-slate-300 border border-slate-300 flex justify-center items-center gap-2">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i> メンテナンスを記録
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- History Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Water History -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="history" class="w-4 h-4 text-slate-500"></i> 水質データの履歴
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="text-xs text-slate-500 bg-white border-b border-slate-200 font-medium uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-3">日時</th>
                                <th class="px-5 py-3">水温</th>
                                <th class="px-5 py-3">pH</th>
                                <th class="px-5 py-3">亜硝酸</th>
                                <th class="px-5 py-3">GH</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($this->historyParameters as $param)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3 text-slate-600">{{ $param->measured_at->format('Y-m-d H:i') }}</td>
                                <td class="px-5 py-3 font-medium">{{ $param->temperature ?? '-' }}</td>
                                <td class="px-5 py-3 font-medium">{{ $param->ph ?? '-' }}</td>
                                <td class="px-5 py-3 font-medium">{{ $param->nitrite ?? '-' }}</td>
                                <td class="px-5 py-3 font-medium">{{ $param->gh ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-slate-400 italic">データがありません。</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Maintenance History -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="list-checks" class="w-4 h-4 text-slate-500"></i> 最近のメンテナンス
                    </h3>
                </div>
                <div class="p-5 space-y-4">
                    @forelse($this->maintenanceHistory as $log)
                    <div class="flex gap-4 border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                        <div class="mt-0.5">
                            <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                @if($log->action === '水換え')
                                    <i data-lucide="waves" class="w-4 h-4"></i>
                                @elseif(str_contains($log->action, '掃除'))
                                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                                @else
                                    <i data-lucide="wrench" class="w-4 h-4"></i>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-800">{{ $log->action }}</div>
                            <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3 h-3"></i> {{ $log->date->format('Y-m-d') }}
                            </div>
                            @if($log->description)
                            <div class="text-sm text-slate-600 mt-2 bg-slate-50 p-2 rounded-lg border border-slate-100">{{ $log->description }}</div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-slate-400 italic py-4">メンテナンス履歴がありません。</div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
