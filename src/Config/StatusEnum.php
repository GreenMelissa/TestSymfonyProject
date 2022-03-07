<?php

namespace App\Config;

/**
 * Класс перечислений статусов заявок
 */
enum StatusEnum: string
{
    case NEW              = 'new';
    case WORK_IN_PROGRESS = 'work_in_progress';
    case FINISHED         = 'finished';
    case CANCELLED        = 'cancelled';

    /**
     * @return string
     */
    public function label(): string {
        return static::getLabel($this);
    }

    /**
     * @param StatusEnum $value
     * @return string
     */
    public static function getLabel(self $value): string {
        return match ($value) {
            StatusEnum::NEW => 'Новая',
            StatusEnum::WORK_IN_PROGRESS => 'В работе',
            StatusEnum::FINISHED => 'Закончена',
            StatusEnum::CANCELLED => 'Отменена',
        };
    }

    /**
     * @return array
     */
    public static function choices(): array {
        return [
            StatusEnum::getLabel(StatusEnum::NEW) => StatusEnum::NEW->value,
            StatusEnum::getLabel(StatusEnum::WORK_IN_PROGRESS) => StatusEnum::WORK_IN_PROGRESS->value,
            StatusEnum::getLabel(StatusEnum::FINISHED) => StatusEnum::FINISHED->value,
            StatusEnum::getLabel(StatusEnum::CANCELLED) => StatusEnum::CANCELLED->value,
        ];
    }
}