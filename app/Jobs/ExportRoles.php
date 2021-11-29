<?php

namespace App\Jobs;

use BristolSU\ControlDB\Export\Exporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ExportRoles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Collection $processingRoles;

    /**
     * Create a new job instance.
     *
     * @param Collection $processingRoles
     */
    public function __construct(Collection $processingRoles)
    {
        $this->processingRoles = $processingRoles;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(sprintf('Exporting %u roles', $this->processingRoles->count()));
        Exporter::driver('airtable')->export($this->processingRoles);
    }
}
