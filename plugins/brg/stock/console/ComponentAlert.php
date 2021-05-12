<?php namespace Brg\Stock\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Brg\Stock\Models\Component as ComponentModel;

class ComponentAlert extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'stock:component_alert_email';

    /**
     * @var string The console command description.
     */
    protected $description = 'Script that will send an email alerting if there are components that need to be replaced';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle(){
      \Log::debug('[ComponentAlert Operation] Operation started by console command');
      $components = ComponentModel::all(); 

      $components_to_replace = [];

      foreach($components as $component) {
        if($component->quantity <= $component->quantity_alert) {
          array_push($components_to_replace, $component);
        }
      }

      $data = [
        'components' => $components_to_replace
      ];

      Mail::sendTo('berguejewelry@brg.com', 'brg.stock::mail.component_alert', $data);
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}