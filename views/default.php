<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 03.07.2015
 */
/* @var $this yii\web\View */
/* @var $widget \skeeks\cms\vk\comments\VkCommentsWidget */
?>

<? if ($widget->apiId) : ?>
    <?
    $this->registerJs(<<<JS
        VK.init({apiId: {$widget->apiId}, onlyWidgets: true});


        (function(sx, $, _)
        {
            sx.classes.VkWidgetComments = sx.classes.Component.extend({

                getResutlOptions: function()
                {
                    var options = this.get('options');
                    var jQWigetWrapper = $("#" + this.get('id'));
                    var jQWigetWrapperParent = jQWigetWrapper.parent();

                    if (this.get('adaptiveWith'))
                    {
                        if (jQWigetWrapperParent.length)
                        {
                            options = _.extend(options, {
                                'width' : jQWigetWrapperParent.width()
                            });
                        }
                    }

                    return options;
                },

                buildWidget: function()
                {
                    VK.Widgets.Comments(this.get('id'), this.getResutlOptions());

                    return this;
                },

                destroyWidget: function()
                {
                    $("#" + this.get('id')).empty();
                    return this;
                },

                _onDomReady: function()
                {
                    var self = this;
                    $( window ).resize(function() {
                       self.destroyWidget().buildWidget();
                    });

                    this.buildWidget();
                }

            });
        })(sx, sx.$, sx._);

        new sx.classes.VkWidgetComments({
            'adaptiveWith' : {$widget->adaptiveWith},
            'id' : '{$widget->id}',
            'options' : {$widget->getJsonOptions()},
        });


JS
    );
    ?>
    <div class="sx-vk-widget-comments-wrapper">
        <div id="<?= $widget->id; ?>"></div>
    </div>
<? endif; ?>