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
    protected $aliases = ['dollar'];

    /**
     * @var string Command Description
     */
    protected $description = 'Exchange Command to fetch the current exchange rate';

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

        // $text = "Dólar: 28,17 | 28,88\n";
        // $text.= "Euro: 29.20 | 31.29\n";
        // $text.= "Peso AR: 1.58 | 2.08\n";
        // $text.= "Real: 8.64 | 9.44\n";

        $this->replyWithMessage(['text' => $text]);
    }
}