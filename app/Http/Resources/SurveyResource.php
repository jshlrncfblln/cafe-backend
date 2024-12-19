<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'family_name' => $this->fathers_lastname ?: $this->mothers_lastname,
            'total_children' => $this->children->count(),
        ]);
    }

    /**
     * Get statistics for marriage status.
     *
     * @param \Illuminate\Database\Eloquent\Collection $surveys
     * @return array
     */
    public static function getMarriageStatusStatistics($surveys)
    {
        $totalFamilies = $surveys->count();
        $marriageStats = [
            'civil' => $surveys->where('marriage_type', 'Civil')->count(),
            'church' => $surveys->where('marriage_type', 'Church')->count(),
            'living_together' => $surveys->where('marriage_type', 'Living Together')->count(),
        ];

        return [
            'labels' => ['Civil', 'Church', 'Living Together'],
            'data' => array_map(function ($count) use ($totalFamilies) {
                return $totalFamilies > 0 ? round(($count / $totalFamilies) * 100, 2) : 0;
            }, $marriageStats),
        ];
    }

    /**
     * Get statistics for income distribution.
     *
     * @param \Illuminate\Database\Eloquent\Collection $surveys
     * @return array
     */
    public static function getIncomeDistributionStatistics($surveys)
    {
        $incomeStats = [
            'low_income' => $surveys->where('family_income', '<', 20000)->count(),
            'medium_income' => $surveys->whereBetween('family_income', [20000, 50000])->count(),
            'high_income' => $surveys->where('family_income', '>', 50000)->count(),
        ];

        return [
            'labels' => ['Low Income (<20k)', 'Medium Income (20k-50k)', 'High Income (>50k)'],
            'data' => array_values($incomeStats),
        ];
    }
}
