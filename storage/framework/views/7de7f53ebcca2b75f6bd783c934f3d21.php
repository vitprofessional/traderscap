<?php
    $fieldWrapperView = $getFieldWrapperView();
    $extraAttributes = $getExtraAttributes();
    $extraInputAttributeBag = $getExtraInputAttributeBag();
    $color = $getColor() ?? 'primary';
    $id = $getId();
    $isAutofocused = $isAutofocused();
    $isDisabled = $isDisabled();
    $isPrefixInline = $isPrefixInline();
    $isReorderable = (! $isDisabled) && $isReorderable();
    $isSuffixInline = $isSuffixInline();
    $placeholder = $getPlaceholder();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixIconColor = $getPrefixIconColor();
    $prefixLabel = $getPrefixLabel();
    $statePath = $getStatePath();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixIconColor = $getSuffixIconColor();
    $suffixLabel = $getSuffixLabel();
?>

<?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $fieldWrapperView] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field' => $field,'class' => 'fi-fo-tags-input-wrp']); ?>
    <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['disabled' => $isDisabled,'inlinePrefix' => $isPrefixInline,'inlineSuffix' => $isSuffixInline,'prefix' => $prefixLabel,'prefixActions' => $prefixActions,'prefixIcon' => $prefixIcon,'prefixIconColor' => $prefixIconColor,'suffix' => $suffixLabel,'suffixActions' => $suffixActions,'suffixIcon' => $suffixIcon,'suffixIconColor' => $suffixIconColor,'valid' => ! $errors->has($statePath),'xOn:focusInput.stop' => '$el.querySelector(\'input\')?.focus()','attributes' => 
            \Filament\Support\prepare_inherited_attributes($attributes)
                ->merge($extraAttributes, escape: false)
                ->class([
                    'fi-fo-tags-input',
                    'fi-disabled' => $isDisabled,
                ])
        ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isDisabled),'inline-prefix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isPrefixInline),'inline-suffix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSuffixInline),'prefix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixLabel),'prefix-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixActions),'prefix-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixIcon),'prefix-icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixIconColor),'suffix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixLabel),'suffix-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixActions),'suffix-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixIcon),'suffix-icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixIconColor),'valid' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(! $errors->has($statePath)),'x-on:focus-input.stop' => '$el.querySelector(\'input\')?.focus()','attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
            \Filament\Support\prepare_inherited_attributes($attributes)
                ->merge($extraAttributes, escape: false)
                ->class([
                    'fi-fo-tags-input',
                    'fi-disabled' => $isDisabled,
                ])
        )]); ?>
        <div
            x-load
            x-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('tags-input', 'filament/forms')); ?>"
            x-data="{
                        state: $wire.<?php echo e($applyStateBindingModifiers("\$entangle('{$statePath}')")); ?>,
                        splitKeys: <?php echo \Illuminate\Support\Js::from($getSplitKeys())->toHtml() ?>,
                        newTag: '',
                        editingIndex: null,

                        createTag() {
                            this.newTag = this.newTag.trim()

                            if (this.newTag === '') {
                                return
                            }

                            const parts = this.newTag.split(',').map(s => s.trim()).filter(s => s !== '')

                            if (parts.length > 1) {
                                if (this.editingIndex !== null) {
                                    this.state.splice(this.editingIndex, 1, ...parts.filter((p, i) => i === 0 || !this.state.includes(p)))
                                    this.editingIndex = null
                                } else {
                                    parts.forEach(p => {
                                        if (!this.state.includes(p)) {
                                            this.state.push(p)
                                        }
                                    })
                                }
                                this.newTag = ''
                                return
                            }

                            const duplicateIndex = this.state.findIndex((tag) => String(tag) === this.newTag)
                            const isDuplicateForAnotherTag = duplicateIndex !== -1 && duplicateIndex !== this.editingIndex

                            if (isDuplicateForAnotherTag) {
                                this.newTag = ''
                                this.editingIndex = null

                                return
                            }

                            if (this.editingIndex !== null) {
                                this.state.splice(this.editingIndex, 1, this.newTag)
                                this.editingIndex = null
                            } else {
                                this.state.push(this.newTag)
                            }

                            this.newTag = ''
                        },

                        beginEdit(index) {
                            const selectedTag = String(this.state[index] ?? '').trim()

                            if (! selectedTag) {
                                return
                            }

                            this.editingIndex = index
                            this.newTag = selectedTag

                            this.$nextTick(() => {
                                const inputElement = this.$el.querySelector('input.fi-input')

                                if (! inputElement) {
                                    return
                                }

                                inputElement.focus()

                                const end = selectedTag.length

                                if (typeof inputElement.setSelectionRange === 'function') {
                                    inputElement.setSelectionRange(end, end)
                                }
                            })
                        },

                        deleteTagByIndex(index) {
                            this.state.splice(index, 1)

                            if (this.editingIndex === index) {
                                this.editingIndex = null
                                this.newTag = ''

                                return
                            }

                            if (this.editingIndex !== null && index < this.editingIndex) {
                                this.editingIndex--
                            }
                        },

                        reorderTags(event) {
                            const reordered = this.state.splice(event.oldIndex, 1)[0]
                            this.state.splice(event.newIndex, 0, reordered)
                            this.state = [...this.state]

                            if (this.editingIndex === null) {
                                return
                            }

                            if (this.editingIndex === event.oldIndex) {
                                this.editingIndex = event.newIndex

                                return
                            }

                            if (event.oldIndex < this.editingIndex && event.newIndex >= this.editingIndex) {
                                this.editingIndex--

                                return
                            }

                            if (event.oldIndex > this.editingIndex && event.newIndex <= this.editingIndex) {
                                this.editingIndex++
                            }
                        },

                        input: {
                            ['x-on:blur']() {
                                this.createTag()
                            },
                            ['x-model']: 'newTag',
                            ['x-on:keydown'](event) {
                                if (['Enter', ...this.splitKeys].includes(event.key)) {
                                    event.preventDefault()
                                    event.stopPropagation()

                                    this.createTag()
                                }
                            },
                            ['x-on:paste']() {
                                this.$nextTick(() => {
                                    if (this.splitKeys.length === 0) {
                                        this.createTag()

                                        return
                                    }

                                    const pattern = this.splitKeys
                                        .map((key) => key.replace(/[/\\-\\\\^$*+?.()|[\]{}]/g, '\\\\$&'))
                                        .join('|')

                                    this.newTag
                                        .split(new RegExp(pattern, 'g'))
                                        .forEach((tag) => {
                                            this.newTag = tag
                                            this.createTag()
                                        })
                                })
                            },
                        },
                    }"
            <?php echo e($getExtraAlpineAttributeBag()); ?>

        >
            <input
                <?php echo e($extraInputAttributeBag
                        ->merge([
                            'autocomplete' => 'off',
                            'autofocus' => $isAutofocused,
                            'disabled' => $isDisabled,
                            'id' => $id,
                            'list' => $id . '-suggestions',
                            'placeholder' => filled($placeholder) ? e($placeholder) : null,
                            'type' => 'text',
                            'x-bind' => 'input',
                            'x-on:keydown.enter.prevent.stop' => 'createTag()',
                        ], escape: false)
                        ->class([
                            'fi-input',
                            'fi-input-has-inline-prefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                            'fi-input-has-inline-suffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                        ])); ?>

            />

            <datalist id="<?php echo e($id); ?>-suggestions">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $getSuggestions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <template
                        x-bind:key="<?php echo \Illuminate\Support\Js::from($suggestion)->toHtml() ?>"
                        x-if="! (state?.includes(<?php echo \Illuminate\Support\Js::from($suggestion)->toHtml() ?>) ?? true)"
                    >
                        <option value="<?php echo e($suggestion); ?>" />
                    </template>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </datalist>

            <div wire:ignore>
                <template x-cloak x-if="state?.length">
                    <div
                        <?php if($isReorderable): ?>
                            x-on:end.stop="reorderTags($event)"
                            x-sortable
                            data-sortable-animation-duration="<?php echo e($getReorderAnimationDuration()); ?>"
                        <?php endif; ?>
                        class="fi-fo-tags-input-tags-ctn"
                    >
                        <template
                            x-for="(tag, index) in state"
                            x-bind:key="`${tag}-${index}`"
                        >
                            <span
                                <?php if($isReorderable): ?>
                                    x-bind:x-sortable-item="index"
                                    x-sortable-handle
                                <?php endif; ?>
                                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'fi-badge',
                                    "fi-color-{$color}",
                                    'fi-reorderable' => $isReorderable,
                                ]); ?>"
                            >
                                <span class="fi-badge-label-ctn">
                                    <span
                                    class="fi-badge-label cursor-text"
                                    x-on:click.stop="beginEdit(index)"
                                >
                                    <?php echo e($getTagPrefix()); ?>


                                    <span x-text="tag"></span>

                                        <?php echo e($getTagSuffix()); ?>

                                    </span>
                                </span>

                                <button
                                    type="button"
                                    class="fi-badge-delete-btn"
                                    x-on:click.stop="deleteTagByIndex(index)"
                                    x-bind:aria-label="'<?php echo e(__('filament-forms::components.tags_input.actions.delete.label')); ?>: ' + tag"
                                >
                                    <?php echo e(\Filament\Support\generate_icon_html(
                                            \Filament\Support\Icons\Heroicon::XMark,
                                            alias: \Filament\Support\View\SupportIconAlias::BADGE_DELETE_BUTTON,
                                            size: \Filament\Support\Enums\IconSize::ExtraSmall,
                                        )); ?>

                                </button>
                            </span>
                        </template>
                    </div>
                </template>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $attributes = $__attributesOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__attributesOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $component = $__componentOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__componentOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/forms/components/editable-tags-input.blade.php ENDPATH**/ ?>