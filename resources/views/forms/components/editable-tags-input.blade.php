@php
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
@endphp

<x-dynamic-component
    :component="$fieldWrapperView"
    :field="$field"
    class="fi-fo-tags-input-wrp"
>
    <x-filament::input.wrapper
        :disabled="$isDisabled"
        :inline-prefix="$isPrefixInline"
        :inline-suffix="$isSuffixInline"
        :prefix="$prefixLabel"
        :prefix-actions="$prefixActions"
        :prefix-icon="$prefixIcon"
        :prefix-icon-color="$prefixIconColor"
        :suffix="$suffixLabel"
        :suffix-actions="$suffixActions"
        :suffix-icon="$suffixIcon"
        :suffix-icon-color="$suffixIconColor"
        :valid="! $errors->has($statePath)"
        x-on:focus-input.stop="$el.querySelector('input')?.focus()"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($attributes)
                ->merge($extraAttributes, escape: false)
                ->class([
                    'fi-fo-tags-input',
                    'fi-disabled' => $isDisabled,
                ])
        "
    >
        <div
            x-load
            x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('tags-input', 'filament/forms') }}"
            x-data="{
                        state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
                        splitKeys: @js($getSplitKeys()),
                        newTag: '',
                        editingIndex: null,

                        createTag() {
                            this.newTag = this.newTag.trim()

                            if (this.newTag === '') {
                                return
                            }

                            const parts = this.newTag.split(' / ').map(s => s.trim()).filter(s => s !== '')

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
            {{ $getExtraAlpineAttributeBag() }}
        >
            <input
                {{
                    $extraInputAttributeBag
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
                        ])
                }}
            />

            <datalist id="{{ $id }}-suggestions">
                @foreach ($getSuggestions() as $suggestion)
                    <template
                        x-bind:key="@js($suggestion)"
                        x-if="! (state?.includes(@js($suggestion)) ?? true)"
                    >
                        <option value="{{ $suggestion }}" />
                    </template>
                @endforeach
            </datalist>

            <div wire:ignore>
                <template x-cloak x-if="state?.length">
                    <div
                        @if ($isReorderable)
                            x-on:end.stop="reorderTags($event)"
                            x-sortable
                            data-sortable-animation-duration="{{ $getReorderAnimationDuration() }}"
                        @endif
                        class="fi-fo-tags-input-tags-ctn"
                    >
                        <template
                            x-for="(tag, index) in state"
                            x-bind:key="`${tag}-${index}`"
                        >
                            <span
                                @if ($isReorderable)
                                    x-bind:x-sortable-item="index"
                                    x-sortable-handle
                                @endif
                                @class([
                                    'fi-badge',
                                    "fi-color-{$color}",
                                    'fi-reorderable' => $isReorderable,
                                ])
                            >
                                <span class="fi-badge-label-ctn">
                                    <span
                                    class="fi-badge-label cursor-text"
                                    x-on:click.stop="beginEdit(index)"
                                >
                                    {{ $getTagPrefix() }}

                                    <span x-text="tag"></span>

                                        {{ $getTagSuffix() }}
                                    </span>
                                </span>

                                <button
                                    type="button"
                                    class="fi-badge-delete-btn"
                                    x-on:click.stop="deleteTagByIndex(index)"
                                    x-bind:aria-label="'{{ __('filament-forms::components.tags_input.actions.delete.label') }}: ' + tag"
                                >
                                    {{
                                        \Filament\Support\generate_icon_html(
                                            \Filament\Support\Icons\Heroicon::XMark,
                                            alias: \Filament\Support\View\SupportIconAlias::BADGE_DELETE_BUTTON,
                                            size: \Filament\Support\Enums\IconSize::ExtraSmall,
                                        )
                                    }}
                                </button>
                            </span>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </x-filament::input.wrapper>
</x-dynamic-component>
