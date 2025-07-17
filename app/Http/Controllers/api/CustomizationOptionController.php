<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomizationOption;
use Illuminate\Http\JsonResponse;

class CustomizationOptionController extends Controller
{
    /**
     * Get all customization options by customization
     * @param int $customizationId Customization ID
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function indexByCustomization($customizationId): JsonResponse
    {
        $customizationOptions = CustomizationOption::where("customization_id", $customizationId)
            ->orderBy("created_at", "desc")
            ->paginate(10);
        return response()->json($customizationOptions)->setStatusCode(200);
    }

    /**
     * Get a specific customization option by customization and option
     * @param int $customizationId Customization ID
     * @param int $optionId Option ID
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function showByCustomizationAndOption($customizationId, $optionId): JsonResponse
    {
        $customizationOption = CustomizationOption::where("customization_id", $customizationId)
            ->where("id", $optionId)
            ->first();
        return response()->json($customizationOption)->setStatusCode(200);
    }
}
