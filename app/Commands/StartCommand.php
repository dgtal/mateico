<?php

namespace App\Commands;

use Telegram\Bot\Commands\Command;


/**
 * Class StartCommand
 */
class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'start';

    /**
     * @var array Command Aliases
     */
    protected $aliases = ['signup'];

    /**
     * @var string Command Description
     */
    protected $description = 'Comando start para comenzar';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $update = $this->getUpdate();

        $name = $update->getMessage()->from->firstName;
        $text = "Hola, $name!\n Escribe /help para obtener la lista de comandos.";

        $this->replyWithMessage(['text' => $text]);
    }
}