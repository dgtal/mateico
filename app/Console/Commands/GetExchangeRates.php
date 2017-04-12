<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetExchangeRates extends Command
{
    protected $url = 'https://www.portal.brou.com.uy/web/guest/cotizaciones';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:exrates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get exchange rates from BROU';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $driver = new \Behat\Mink\Driver\GoutteDriver();
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit($this->url);

        $page = $session->getPage();

        $table_rows = $page->findAll('xpath', '//table/tbody/tr');

        if (null === $table_rows) {
            throw new \Exception('Table not found');
        }

        $exchange_rates = [];

        foreach ($table_rows as $row) {
            $tds = $row->findAll('xpath', '//td');

            $slug_name = str_slug($tds[0]->getText());

            $exchange_rates[$slug_name] = [];

            foreach($tds as $td) {
                $content = trim($td->getText());

                if (strlen($content) > 0)
                    $exchange_rates[$slug_name][] = $content;
            }
        }

        file_put_contents(storage_path('exchange_rates.json'), json_encode($exchange_rates));

        $exchange_rates = json_decode(file_get_contents(storage_path('exchange_rates.json')), true);

        $whitelist = ['dolar', 'euro', 'peso-argentino', 'real'];

        $xx = array_intersect_key($exchange_rates, array_flip($whitelist));

        dd($xx);
    }
}