<?php namespace PlanetaDelEste\PostmarkDriver;

use Backend\Widgets\Form;
use Coconuts\Mail\PostmarkTransport;
use Event;
use GuzzleHttp\Client;
use System\Classes\PluginBase;
use System\Models\MailSetting;

/**
 * Class Plugin
 * @package PlanetaDelEste\PostmarkDriver
 */
class Plugin extends PluginBase
{
    const MODE_POSTMARK = 'postmark';

    public function boot()
    {
        Event::listen('backend.form.extendFields', function (Form $widget) {

            if (!$widget->getController() instanceof \System\Controllers\Settings) {
                return;
            }

            if (!$widget->model instanceof MailSetting) {
                return;
            }

            $field = $widget->getField('send_mode');
            $field->options(array_merge($field->options(), [self::MODE_POSTMARK => "Postmark"]));

            $widget->addTabFields([
                'postmark_secret' => [
                    "tab"     => "system::lang.mail.general",
                    'label'   => 'planetadeleste.postmarkdriver::lang.field.secret',
                    'comment' => 'planetadeleste.postmarkdriver::lang.field.secret_comment',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'send_mode',
                        'condition' => 'value[postmark]'
                    ]
                ],
            ]);
        });

        \App::extend('swift.transport', function (\Illuminate\Mail\TransportManager $manager) {
            return $manager->extend(self::MODE_POSTMARK, function () {
                $settings = MailSetting::instance();
                $client = new Client();
                return new PostmarkTransport($client, $settings->postmark_secret);
            });
        });

        MailSetting::extend(function ($model) {
            $model->bindEvent('model.beforeValidate', function () use ($model) {
                $model->rules['postmark_secret'] = 'required_if:send_mode,' . self::MODE_POSTMARK;
            });
        });
    }
}
