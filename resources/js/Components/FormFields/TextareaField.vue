<template>
    <div class="grid grid-cols-1 gap-3 md:grid-cols-1 rounded-xl border border-orange-200 p-2">
        <label for="{{ fieldId }}" class="font-medium">{{ label }}</label>
        <textarea
            id="{{ fieldId }}"
            class="m-1 border-b border-b-orange-200 focus:bg-white focus:p-2 focus:border-b-4 focus-visible:outline-none transition-all duration-300 ease-in-out hover:border-b-4"
            v-model="value"
            :placeholder="placeholder"
        ></textarea>
        <span class="error" v-if="isValid === false">{{ assertion.message }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            modelValue: String,
            label: String,
            placeholder: String,
            assertion: {
                type: Object,
                validator(value) {
                    return
                        value.regex instanceof RegExp
                        && typeof value.message === 'string';
                }
            },
        },
        data() {
            return {
                fieldId: 'field-' + this._uid,
                isValid: null,
            }
        },
        methods: {
            validate() {
                if (this.assertion !== undefined) {
                    this.isValid = this.assertion.regex.test(this.value ? this.value : '')
                } else {
                    this.isValid = true;
                }
                
                this.$emit("validation", this.isValid);
            },
            reset() {
                this.isValid = null;
                this.$emit("validation", this.isValid);
                this.$emit("update:modelValue", null);
            }
        },
        computed: {
            value: {
                get() { return this.modelValue },
                set(val) { this.$emit("update:modelValue", val) }
            },
        },
        watch: {
            value(newVal) {
                if (newVal !== null) {
                    this.validate();
                }
            },
        }
    }
</script>
