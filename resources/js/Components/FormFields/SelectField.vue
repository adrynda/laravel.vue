<template>
    <div class="grid grid-cols-1 gap-3 md:grid-cols-1 rounded-xl border border-orange-200 p-2">
        <label :for="fieldId" class="font-medium">{{ label }}</label>
        <!-- <select :id="fieldId" v-model="value" class="m-1 border-b border-b-orange-200 focus:bg-white appearance-none rounded focus:ring transition-all"> -->
        <select
            class="
                border-b border-b-orange-200 bg-none
                px-2 py-1
                hover:border-b-4
                transition-all duration-300 ease-in-out
                focus:bg-white
            "
            :id="fieldId"
            v-model="value" 
        >
            <option disabled value="">{{ placeholder }}</option>
            <option
                v-for="(option, index) in options"
                :key="index"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>
        <span class="error" v-if="isValid === false">{{ assertion?.message }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            modelValue: [String, Number],
            label: String,
            placeholder: String,
            options: {
                type: Array,
                required: true,
            },
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
        select {
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
