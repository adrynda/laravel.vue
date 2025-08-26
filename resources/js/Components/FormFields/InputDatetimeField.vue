<template>
    <div class="form-field">
        <label :for="fieldId">{{ label }}</label>
        <input type="datetime-local" :id="fieldId" v-model="value" />
        <span class="error" v-if="isValid === false">{{ assertion?.message }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            modelValue: String,
            label: String,
            assertion: {
                required: false,
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

<style scoped>
    div.form-field {
        margin-bottom: 10px;
        input {
            display: block;
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
            resize: vertical;
        }
        span.error {
            color: red;
        }
    }
</style>
