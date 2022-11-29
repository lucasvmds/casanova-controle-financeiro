<?php

declare(strict_types=1);

namespace App\Support;

use Inertia\Inertia;

class FlashMessages
{
    public function __construct(
        private bool $share_now = false,
    ){}

    private function shouldShareNow(): bool
    {
        return (bool) Inertia::getShared('flash_messages') || $this->share_now;
    }

    private function add(string $level, string $content): void
    {
        $message_data = [
            'id' => uniqid(),
            'level' => $level,
            'content' => $content,
        ];

        if ($this->shouldShareNow()) {
            $messages = Inertia::getShared('flash_messages', []);
            $messages[] = $message_data;
            Inertia::share('flash_messages', $messages);
        } else {
            $messages = session()->get('flash_messages', []);
            $messages[] = $message_data;
            session()->flash('flash_messages', $messages);
        }
    }

    public function success(string $content): self
    {
        $this->add('success', $content);
        return $this;
    }

    public function warning(string $content): self
    {
        $this->add('warning', $content);
        return $this;
    }

    public function error(string $content): self
    {
        $this->add('error', $content);
        return $this;
    }

    public static function shareNow(): self
    {
        return new static(true); 
    }

    public static function getSharedMessages(): array
    {
        return session()->get('flash_messages', []);
    }
}