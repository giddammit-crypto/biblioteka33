(function(wp) {
    var el = wp.element.createElement;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor ? wp.blockEditor.InspectorControls : wp.editor.InspectorControls;
    var MediaPlaceholder = wp.blockEditor ? wp.blockEditor.MediaPlaceholder : wp.editor.MediaPlaceholder;
    var BlockControls = wp.blockEditor ? wp.blockEditor.BlockControls : wp.editor.BlockControls;
    var PanelBody = wp.components.PanelBody;
    var SelectControl = wp.components.SelectControl;
    var ToggleControl = wp.components.ToggleControl;

    registerBlockType('city-library/slider', {
        title: 'Слайдер изображений',
        icon: 'images-alt2',
        category: 'media',
        attributes: {
            images: {
                type: 'array',
                default: []
            },
            ids: {
                type: 'string',
                default: ''
            },
            ratio: {
                type: 'string',
                default: '21/9'
            },
            effect: {
                type: 'string',
                default: 'fade'
            },
            objectFit: {
                type: 'string',
                default: 'cover'
            },
            autoplay: {
                type: 'boolean',
                default: true
            }
        },

        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var onSelectImages = function(media) {
                var newImages = media.map(function(item) {
                    return { id: item.id, url: item.url };
                });
                var newIds = newImages.map(function(item) { return item.id; }).join(',');

                setAttributes({
                    images: newImages,
                    ids: newIds
                });
            };

            var controls = el(
                InspectorControls,
                {},
                el(
                    PanelBody,
                    { title: 'Настройки слайдера', initialOpen: true },
                    el(SelectControl, {
                        label: 'Соотношение сторон',
                        value: attributes.ratio,
                        options: [
                            { label: 'Широкий (21:9)', value: '21/9' },
                            { label: 'Стандартный (16:9)', value: '16/9' },
                            { label: 'Квадратный (1:1)', value: '1/1' },
                            { label: 'Классический (4:3)', value: '4/3' }
                        ],
                        onChange: function(value) { setAttributes({ ratio: value }); }
                    }),
                    el(SelectControl, {
                        label: 'Эффект переключения',
                        value: attributes.effect,
                        options: [
                            { label: 'Затухание (Fade)', value: 'fade' },
                            { label: 'Скольжение (Slide)', value: 'slide' },
                            { label: 'Куб (Cube)', value: 'cube' },
                            { label: 'Переворот (Flip)', value: 'flip' }
                        ],
                        onChange: function(value) { setAttributes({ effect: value }); }
                    }),
                    el(SelectControl, {
                        label: 'Вписывание изображений',
                        value: attributes.objectFit,
                        options: [
                            { label: 'Заполнение (Cover)', value: 'cover' },
                            { label: 'Вмещение (Contain)', value: 'contain' }
                        ],
                        onChange: function(value) { setAttributes({ objectFit: value }); }
                    }),
                    el(ToggleControl, {
                        label: 'Автовоспроизведение',
                        checked: attributes.autoplay,
                        onChange: function(value) { setAttributes({ autoplay: value }); }
                    })
                )
            );

            if (attributes.images.length === 0) {
                return [
                    controls,
                    el(
                        MediaPlaceholder,
                        {
                            icon: 'images-alt2',
                            labels: { title: 'Изображения для слайдера' },
                            onSelect: onSelectImages,
                            accept: 'image/*',
                            multiple: true
                        }
                    )
                ];
            }

            var ratioStyle = attributes.ratio.replace('/', ':'); // CSS format 16:9

            // Preview render
            return [
                controls,
                el(
                    'div',
                    {
                        className: 'wp-block-city-library-slider',
                        style: {
                            position: 'relative',
                            border: '1px solid #ccc',
                            borderRadius: '8px',
                            overflow: 'hidden',
                            backgroundColor: '#f1f1f1',
                            display: 'flex',
                            flexDirection: 'column'
                        }
                    },
                    el(
                        'div',
                        {
                            style: {
                                aspectRatio: attributes.ratio,
                                position: 'relative',
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                background: '#eee',
                                backgroundImage: 'url(' + attributes.images[0].url + ')',
                                backgroundSize: attributes.objectFit,
                                backgroundPosition: 'center',
                                backgroundRepeat: 'no-repeat'
                            }
                        },
                        el(
                            'div',
                            {
                                style: {
                                    position: 'absolute',
                                    bottom: '10px',
                                    right: '10px',
                                    background: 'rgba(0,0,0,0.6)',
                                    color: 'white',
                                    padding: '4px 8px',
                                    borderRadius: '4px',
                                    fontSize: '12px'
                                }
                            },
                            'Слайдов: ' + attributes.images.length + ' (' + attributes.ratio + ')'
                        )
                    )
                )
            ];
        },

        save: function(props) {
            var attributes = props.attributes;
            if (!attributes.ids) return null;

            // Generate the shortcode explicitly to be rendered on the frontend
            var shortcode = '[city_library_slider ids="' + attributes.ids + '" ' +
                            'ratio="' + attributes.ratio + '" ' +
                            'effect="' + attributes.effect + '" ' +
                            'object_fit="' + attributes.objectFit + '" ' +
                            'autoplay="' + (attributes.autoplay ? 'true' : 'false') + '"]';

            return el(wp.element.RawHTML, {}, shortcode);
        }
    });
})(window.wp);