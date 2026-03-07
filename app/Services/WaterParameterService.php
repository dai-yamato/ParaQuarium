<?php

namespace App\Services;

use App\Models\WaterParameter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WaterParameterService
{
    /**
     * 店舗やIoTデバイスから水質データを保存する
     *
     * @param int $tankId
     * @param array $data
     * @return WaterParameter
     * @throws ValidationException
     */
    public function recordParameters(int $tankId, array $data): WaterParameter
    {
        $validator = Validator::make($data, [
            'ph' => ['nullable', 'numeric', 'min:0', 'max:14'],
            'temperature' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'nitrite' => ['nullable', 'numeric', 'min:0'],
            'gh' => ['nullable', 'numeric', 'min:0'],
            'measured_at' => ['required', 'date'],
        ], [
            'ph.numeric' => 'pHは数値で入力してください',
            'ph.min' => 'pHは0以上で入力してください',
            'ph.max' => 'pHは14以下で入力してください',
            'temperature.numeric' => '水温は数値で入力してください',
            'temperature.min' => '水温は0以上で入力してください',
            'temperature.max' => '水温は50以下で入力してください',
            'nitrite.numeric' => '亜硝酸は数値で入力してください',
            'nitrite.min' => '亜硝酸は0以上で入力してください',
            'gh.numeric' => '総硬度(GH)は数値で入力してください',
            'gh.min' => '総硬度(GH)は0以上で入力してください',
            'measured_at.required' => '測定日時は必須です',
            'measured_at.date' => '正しい測定日時を入力してください',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $validated['tank_id'] = $tankId;

        return WaterParameter::create($validated);
    }
}
