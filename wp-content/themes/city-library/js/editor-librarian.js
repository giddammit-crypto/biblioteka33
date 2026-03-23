(function(wp) {
    const { registerPlugin } = wp.plugins;
    const { PluginBlockSettingsMenuItem } = wp.editPost;
    const { select, dispatch } = wp.data;
    const { useState } = wp.element;
    const { Modal, Button, TextareaControl, Icon, Popover } = wp.components;
    const { RichTextToolbarButton } = wp.blockEditor;
    const { registerFormatType, insertObject } = wp.richText;

    // 1. AI Text Analysis Plugin
    const LibrarianEditorPlugin = () => {
        const [isOpen, setIsOpen] = useState(false);
        const [originalText, setOriginalText] = useState('');
        const [improvedText, setImprovedText] = useState('');
        const [isLoading, setIsLoading] = useState(false);
        const [error, setError] = useState('');

        const analyzeText = () => {
            const selectedBlock = select('core/block-editor').getSelectedBlock();
            if (!selectedBlock) return;

            const content = selectedBlock.attributes.content || selectedBlock.attributes.value || '';
            if (!content) return;

            setOriginalText(content);
            setIsOpen(true);
            setIsLoading(true);
            setError('');
            setImprovedText('');

            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'city_library_ai_chat',
                    nonce: cityLibraryEditorAI.nonce,
                    message: `Ты — литературный редактор. Улучши этот текст для сайта библиотеки, сделай его более официальным, но дружелюбным. Верни ТОЛЬКО исправленный текст без вступлений:\n\n${content}`
                },
                success: (response) => {
                    if (response.success) {
                        setImprovedText(response.data.reply);
                    } else {
                        setError(response.data.reply || 'Ошибка анализа');
                    }
                },
                error: () => setError('Ошибка связи с сервером'),
                complete: () => setIsLoading(false)
            });
        };

        const replaceContent = () => {
            const selectedBlock = select('core/block-editor').getSelectedBlock();
            if (selectedBlock) {
                const attrName = selectedBlock.attributes.content !== undefined ? 'content' : 'value';
                dispatch('core/block-editor').updateBlockAttributes(selectedBlock.clientId, {
                    [attrName]: improvedText
                });
                setIsOpen(false);
            }
        };

        return (
            <>
                <PluginBlockSettingsMenuItem
                    icon="admin-appearance"
                    label="Улучшить (ИИ Библиотекарь)"
                    onClick={analyzeText}
                />

                {isOpen && (
                    <Modal title="Анализ текста Виртуальным библиотекарем" onRequestClose={() => setIsOpen(false)} className="ai-editor-modal">
                        <div style={{ padding: '20px', minWidth: '400px' }}>
                            {isLoading ? (
                                <div style={{ textAlign: 'center', padding: '40px' }}>
                                    <Icon icon="update" className="animate-spin" style={{ fontSize: '32px' }} />
                                    <p>Библиотекарь изучает текст...</p>
                                </div>
                            ) : error ? (
                                <p style={{ color: 'red' }}>{error}</p>
                            ) : (
                                <>
                                    <div style={{ marginBottom: '20px' }}>
                                        <strong>Оригинал:</strong>
                                        <div style={{ background: '#f8fafc', padding: '12px', borderRadius: '8px', fontSize: '13px', border: '1px solid #e2e8f0', marginTop: '8px' }}>{originalText}</div>
                                    </div>
                                    <div style={{ marginBottom: '20px' }}>
                                        <strong>Предложение библиотекаря:</strong>
                                        <TextareaControl
                                            value={improvedText}
                                            onChange={(val) => setImprovedText(val)}
                                            rows={8}
                                        />
                                    </div>
                                    <div style={{ display: 'flex', gap: '10px', justifyContent: 'flex-end' }}>
                                        <Button isSecondary onClick={() => setIsOpen(false)}>Отмена</Button>
                                        <Button isPrimary onClick={replaceContent}>Заменить текст</Button>
                                    </div>
                                </>
                            )}
                        </div>
                    </Modal>
                )}
            </>
        );
    };

    registerPlugin('city-library-librarian-editor', {
        render: LibrarianEditorPlugin,
        icon: 'admin-appearance',
    });

    // 2. Emoji Inserter RichText Format
    const EmojiFormat = ({ isActive, onChange, value }) => {
        const [ isVisible, setIsVisible ] = useState( false );
        const emojis = ['📚', '📖', '📗', '📘', '📙', '📓', '📔', '📒', '📕', '✍️', '📝', '💡', '🏛️', '🎓', '✨', '📅', '📍', '📞', '👋', '😊'];

        return (
            <RichTextToolbarButton
                icon="smiley"
                title="Вставить эмодзи"
                onClick={ () => setIsVisible( true ) }
                isActive={ isActive }
            >
                { isVisible && (
                    <Popover
                        onClose={ () => setIsVisible( false ) }
                        position="bottom center"
                    >
                        <div style={{ padding: '10px', display: 'grid', gridTemplateColumns: 'repeat(5, 1fr)', gap: '5px', background: '#fff' }}>
                            {emojis.map(emoji => (
                                <Button
                                    key={emoji}
                                    isTertiary
                                    onClick={() => {
                                        onChange(insertObject(value, {
                                            type: 'city-library/emoji',
                                            attributes: { content: emoji }
                                        }));
                                        setIsVisible(false);
                                    }}
                                    style={{ fontSize: '20px', padding: '5px' }}
                                >
                                    {emoji}
                                </Button>
                            ))}
                        </div>
                    </Popover>
                ) }
            </RichTextToolbarButton>
        );
    };

    registerFormatType('city-library/emoji', {
        title: 'Emoji',
        tagName: 'span',
        className: 'emoji-span',
        edit: EmojiFormat,
    });

})(window.wp);
