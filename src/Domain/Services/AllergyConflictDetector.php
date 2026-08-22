<?php

namespace Mod15\Domain\Services;

use Mod15\Domain\Entities\Allergy;
use Mod15\Domain\Entities\Medication;

final class AllergyConflictDetector
{
    /** @param list<Allergy> $allergies */
    public function detect(Medication $medication, array $allergies): ?Allergy
    {
        $targets = [
            $this->normalize($medication->name),
            $this->normalize($medication->activeIngredient),
        ];

        foreach ($allergies as $allergy) {
            if (!$allergy->active || !$allergy->isCritical()) {
                continue;
            }

            $substance = $this->normalize($allergy->substance);

            foreach ($targets as $target) {
                if ($target !== '' && $substance !== '' && (str_contains($target, $substance) || str_contains($substance, $target))) {
                    return $allergy;
                }
            }
        }

        return null;
    }

    private function normalize(string $value): string
    {
        return strtolower(trim($value));
    }
}
