<?php

declare(strict_types=1);

namespace Orchid\Backup;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;

class BackupLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'backups';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('path', __('Path'))
             ->render(function ($file) {       	
                return Link::make($file['file'])->route('platform.backups.downloadFile', $file['file']);
            }),
            
            TD::make('disk', __('Disk')),
            TD::make('size', __('Size')),
            TD::make('last_modified', __('Last change')),
        ];
    }
}


