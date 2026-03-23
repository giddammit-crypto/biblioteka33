(function(wp) {
    const { registerPlugin } = wp.plugins;
    const { select, dispatch } = wp.data;
    const { useState } = wp.element;
    const { Modal, Button, TextareaControl, Icon, Popover, ToolbarGroup, ToolbarButton } = wp.components;
    const { RichTextToolbarButton, BlockControls } = wp.blockEditor;
    const { registerFormatType, insertObject } = wp.richText;

    // 1. AI Text Analysis Component
    const LibrarianEditorPlugin = () => {
        const [isOpen, setIsOpen] = useState(false);
        const [originalText, setOriginalText] = useState('');
        const [improvedText, setImprovedText] = useState('');
        const [isLoading, setIsLoading] = useState(false);
        const [error, setError] = useState('');

        const analyzeText = () => {
            const selectedBlock = select('core/block-editor').getSelectedBlock();
            if (!selectedBlock) return;

            // Target common text-based attributes
            const content = selectedBlock.attributes.content || selectedBlock.attributes.value || '';
            if (!content) {
                alert('Сначала введите текст в блок, чтобы я могла его проанализировать.');
                return;
            }

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
                    message: `Ты — профессиональный редактор. Улучши этот текст для сайта библиотеки. Сделай его стилистически правильным, вдохновляющим и грамотным. Верни ТОЛЬКО улучшенный текст без лишних фраз:\n\n${content}`
                },
                success: (response) => {
                    if (response.success) {
                        setImprovedText(response.data.reply);
                    } else {
                        setError(response.data.reply || 'Библиотекарь сейчас занят, попробуйте позже.');
                    }
                },
                error: () => setError('Ошибка связи с сервером. Проверьте интернет.'),
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

        // Determine if the currently selected block is a text block
        const selectedBlockType = select('core/block-editor').getSelectedBlock()?.name;
        const isTextBlock = selectedBlockType && ['core/paragraph', 'core/heading', 'core/list', 'core/quote'].includes(selectedBlockType);

        return (
            <>
                {isTextBlock && (
                    <BlockControls>
                        <ToolbarGroup>
                            <ToolbarButton
                                icon="admin-appearance"
                                label="Улучшить текст (ИИ)"
                                onClick={analyzeText}
                                className="ai-librarian-toolbar-btn"
                            />
                        </ToolbarGroup>
                    </BlockControls>
                )}

                {isOpen && (
                    <Modal
                        title="✨ Анализ текста Виртуальным библиотекарем"
                        onRequestClose={() => setIsOpen(false)}
                        className="ai-editor-modal"
                    >
                        <div style={{ padding: '20px', minWidth: '450px' }}>
                            {isLoading ? (
                                <div style={{ textAlign: 'center', padding: '50px' }}>
                                    <Icon icon="update" className="animate-spin" style={{ fontSize: '40px', color: '#0b7930' }} />
                                    <p style={{ marginTop: '15px', fontWeight: 'bold' }}>Библиотекарь изучает ваш текст...</p>
                                </div>
                            ) : error ? (
                                <div style={{ padding: '20px', textAlign: 'center' }}>
                                    <p style={{ color: '#d32f2f' }}>{error}</p>
                                    <Button isSecondary onClick={() => setIsOpen(false)}>Закрыть</Button>
                                </div>
                            ) : (
                                <>
                                    <div style={{ marginBottom: '20px' }}>
                                        <label style={{ display: 'block', marginBottom: '8px', fontWeight: 'bold', fontSize: '12px', textTransform: 'uppercase', color: '#64748b' }}>Ваш оригинал:</label>
                                        <div style={{ background: '#f8fafc', padding: '15px', borderRadius: '12px', fontSize: '14px', border: '1px solid #e2e8f0', color: '#475569', fontStyle: 'italic' }}>
                                            {originalText}
                                        </div>
                                    </div>
                                    <div style={{ marginBottom: '25px' }}>
                                        <label style={{ display: 'block', marginBottom: '8px', fontWeight: 'bold', fontSize: '12px', textTransform: 'uppercase', color: '#0b7930' }}>Версия библиотекаря:</label>
                                        <TextareaControl
                                            value={improvedText}
                                            onChange={(val) => setImprovedText(val)}
                                            rows={10}
                                            style={{ borderRadius: '12px', borderColor: '#0b7930', padding: '12px' }}
                                        />
                                        <p style={{ fontSize: '11px', color: '#94a3b8', marginTop: '5px' }}>Вы можете отредактировать предложенный текст перед заменой.</p>
                                    </div>
                                    <div style={{ display: 'flex', gap: '12px', justifyContent: 'flex-end', borderTop: '1px solid #f1f5f9', paddingTop: '20px' }}>
                                        <Button isTertiary onClick={() => setIsOpen(false)}>Оставить как есть</Button>
                                        <Button
                                            isPrimary
                                            onClick={replaceContent}
                                            style={{ background: '#0b7930', borderColor: '#0b7930', borderRadius: '8px', fontWeight: 'bold' }}
                                        >
                                            Применить изменения
                                        </Button>
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
    });

    // 2. Emoji Inserter RichText Format (Stays in the text selection toolbar)
    const EmojiFormat = ({ isActive, onChange, value }) => {
        const [ isVisible, setIsVisible ] = useState( false );
        const emojis = ['📚', '📖', '📗', '📘', '📙', '📓', '📔', '📒', '📕', '✍️', '📝', '💡', '🏛️', '🎓', '✨', '📅', '📍', '📞', '👋', '😊', '🎭', '🎨', '🔍', '📌', '🤝'];

        return (
            <RichTextToolbarButton
                icon="smiley"
                title="Вставить эмодзи"
                onClick={ () => setIsVisible( true ) }
                isActive={ isActive }
            />
        );
    };

    // Need a separate component for the popover to handle its state correctly inside FormatType
    const EmojiPicker = ( props ) => {
        const [ isVisible, setIsVisible ] = useState( false );
        const emojis = ['📚', '📖', '📗', '📘', '📙', '📓', '📔', '📒', '📕', '✍️', '📝', '💡', '🏛️', '🎓', '✨', '📅', '📍', '📞', '👋', '😊', '🎭', '🎨', '🔍', '📌', '🤝'];

        return (
            <>
                <RichTextToolbarButton
                    icon="smiley"
                    title="Вставить эмодзи"
                    onClick={ () => setIsVisible( ! isVisible ) }
                />
                { isVisible && (
                    <Popover
                        onClose={ () => setIsVisible( false ) }
                        position="bottom center"
                    >
                        <div style={{ padding: '12px', display: 'grid', gridTemplateColumns: 'repeat(5, 1fr)', gap: '8px', background: '#fff', borderRadius: '8px', shadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1)' }}>
                            {emojis.map(emoji => (
                                <Button
                                    key={emoji}
                                    isTertiary
                                    onClick={() => {
                                        props.onChange(insertObject(props.value, {
                                            type: 'city-library/emoji',
                                            attributes: { content: emoji }
                                        }));
                                        setIsVisible(false);
                                    }}
                                    style={{ fontSize: '24px', padding: '8px', lineHeight: '1' }}
                                >
                                    {emoji}
                                </Button>
                            ))}
                        </div>
                    </Popover>
                ) }
            </>
        );
    };

    registerFormatType('city-library/emoji', {
        title: 'Emoji',
        tagName: 'span',
        className: 'emoji-span',
        edit: EmojiPicker,
    });

})(window.wp);
