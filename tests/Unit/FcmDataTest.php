<?php

namespace AhmedHegazy\FcmHelper\Tests\Unit;

use AhmedHegazy\FcmHelper\FcmData;
use AhmedHegazy\FcmHelper\Tests\TestCase;

class FcmDataTest extends TestCase
{
    /** @test */
    public function it_can_create_data_with_notify_type()
    {
        $data = new FcmData('test-type');
        $array = $data->toArray();

        $this->assertEquals('general', $array['notify_type'], 'The default notify type should be "general"');
    }

    /** @test */
    public function it_can_add_custom_data()
    {
        $data = new FcmData('test-type');
        $data->add('key1', 'value1')
            ->add('key2', 'value2');

        $array = $data->toArray();

        $this->assertEquals('value1', $array['key1']);
        $this->assertEquals('value2', $array['key2']);
    }

    /** @test */
    public function it_can_hide_notification()
    {
        $data = new FcmData('test-type');
        $data->hide();

        $array = $data->toArray();

        $this->assertEquals(1, $array['is_hidden']);
    }

    /** @test */
    public function it_can_show_notification()
    {
        $data = new FcmData('test-type');
        $data->hide()->show();

        $array = $data->toArray();

        $this->assertEquals(0, $array['is_hidden']);
    }

    /** @test */
    public function it_maintains_chaining_for_data_methods()
    {
        $data = new FcmData('test-type');

        $result = $data->add('key1', 'value1')
            ->hide()
            ->show()
            ->add('key2', 'value2');

        $this->assertInstanceOf(FcmData::class, $result);

        $array = $result->toArray();
        $this->assertEquals('value1', $array['key1']);
        $this->assertEquals('value2', $array['key2']);
        $this->assertEquals(0, $array['is_hidden']);
    }
}
