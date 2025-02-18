<?php

namespace App\Twig;

use App\Enum\TaskStatusEnum;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TaskStatusExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('task_status_label', [$this, 'formatTaskStatus']),
        ];
    }

    public function formatTaskStatus(TaskStatusEnum $status): string
    {
        return match ($status) {
            TaskStatusEnum::PENDING => 'Pending',
            TaskStatusEnum::IN_PROGRESS => 'In progress',
            TaskStatusEnum::COMPLETED => 'Completed',
        };
    }
}
