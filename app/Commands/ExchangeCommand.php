<?php

namespace App\Commands;

use Telegram\Bot\Commands\Command;


/**
 * Class StartCommand
 */
class ExchangeCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'exchange';

    /**
     * @var array Command Aliases
     */
    protected $aliases = ['cotizacion'];

    /**
     * @var string Command Description
     */
    protected $description = 'Comando para obtener las cotizaciones del BROU';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $update = $this->getUpdate();

        $whitelist = ['dolar', 'euro', 'peso-argentino', 'real'];

        $exchange_rates = json_decode(file_get_contents(storage_path('exchange_rates.json')), true);

        $exchange_rates = array_intersect_key($exchange_rates, array_flip($whitelist));

        $text = '';

        foreach ($exchange_rates as $exchange_rate) {
            $text .= implode(' - ', $exchange_rate) . "\n";
        }

        $this->replyWithMessage(['text' => $text]);
    }
}