<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\LivroRepository;
use Illuminate\Support\Facades\DB; 
use App\Services\IndiceService;
use App\Helpers\XmlParser;

class ImportIndicesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $xmlData;
    protected $livroId;

    /**
     * Create a new job instance.
     *
     * @param string $xmlData XML data to import
     * @param int $livroId ID of the livro associated with the indices
     */
    public function __construct($xmlData, $livroId)
    {
        $this->xmlData = $xmlData;
        $this->livroId = $livroId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LivroRepository $livroRepository, IndiceService $indiceService)
    {
        
        try {
            DB::beginTransaction();
            $xml = simplexml_load_string($this->xmlData);

            $structuredData = XmlParser::xmlToArray($xml);
            $livro = $livroRepository->find($this->livroId);
       
            $indiceService->insertIndices($livro, $structuredData);
            DB::commit();

            \Log::info('Indices imported successfully.');            
        } catch (\Exception $e) {
            DB::rollback();

            \Log::info($e);
        }
    }
}
