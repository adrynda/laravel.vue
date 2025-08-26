<template>
    <div class="form">
        <InputTextField
            label="Tytuł"
            placeholder="Tytuł"
            :assertion="{ regex: /^.{3,}$/, message: 'Minimum 3 znaki' }"
            ref="titleField"
            v-model="title"
            @validation="fieldValid.title = $event"
        />
        <InputDatetimeField
            label="Data realizacji"
            ref="dueDateField"
            :assertion="{ regex: /^.{1,}$/, message: 'Pole nie może być puste' }"
            v-model="dueDate"
            @validation="fieldValid.dueDate = $event"
        />
        <SelectField
            label="Priorytet"
            placeholder="Priorytet"
            :options="[
                { value: 'low', label: 'Niski' },
                { value: 'medium', label: 'Średni' },
                { value: 'high', label: 'Wysoki' }
            ]"
            ref="priorityField"
            :assertion="{ regex: /^.{1,}$/, message: 'Pole nie może być puste' }"
            v-model="priority"
            @validation="fieldValid.priority = $event"
        />
        <InputTextField
            label="Kategoria"
            placeholder="Kategoria"
            :assertion="{ regex: /^.{3,}$/, message: 'Minimum 3 znaki' }"
            ref="categoryField"
            v-model="category"
            @validation="fieldValid.category = $event"
        />
        <TextareaField
            label="Notatki"
            placeholder="Notatki"
            :assertion="{ regex: /^.{1,}$/, message: 'Pole nie może być puste' }"
            ref="notesField"
            v-model="notes"
            @validation="fieldValid.notes = $event"
        />
        <button @click="create">Dodaj</button>
        <button @click="clear">Wyczyść</button>
    </div>
</template>

<script>
    import InputTextField from '../../Components/FormFields/InputTextField.vue';
    import InputDatetimeField from '../../Components/FormFields/InputDatetimeField.vue';
    import SelectField from '../../Components/FormFields/SelectField.vue';
    import TextareaField from '../../Components/FormFields/TextareaField.vue';



    export default {
        components: {
            InputTextField,
            InputDatetimeField,
            SelectField,
            TextareaField,
        },
        data() {
            return {
                title: null,
                completed: false,
                dueDate: null,
                priority: null,
                category: null,
                notes: null,
                fieldValid: {
                    title: false,
                    dueDate: false,
                    priority: false,
                    category: false,
                    notes: false,
                },
                errors: [],
            }
        },
        methods: {
            clear() {
                this.$refs.titleField.reset();
                this.$refs.dueDateField.reset();
                this.$refs.priorityField.reset();
                this.$refs.categoryField.reset();
                this.$refs.notesField.reset();
            },
            create() {
                if (!this.isFormValid()) {
                    alert("Formularz zawiera błędy!");
                    return;
                }
                
                const newItem = {
                    id: null,
                    title: this.title,
                    dueDate: new Date(this.dueDate),
                    priority: this.priority,
                    category: this.category,
                    notes: this.notes,
                    completed: this.completed,
                    // createdAt: new Date(),
                };
                
                this.$emit('add', newItem);
                this.clear();
            },
            isFormValid() {
                this.$refs.titleField.validate();
                this.$refs.dueDateField.validate();
                this.$refs.priorityField.validate();
                this.$refs.categoryField.validate();
                this.$refs.notesField.validate();
                
                return Object.values(this.fieldValid).every(v => v === true);
            },
        },
        computed: {
            validateField(field) {
                if (typeof item[field] !== this.assertions[field]) {
                    isValid = false;
                    this.errors[field] = `Invalid type for field ${field}, expected ${this.assertions[assertion]}, got ${typeof item[assertion]}`;
                }
            },
        }
    }
</script>

<style scoped>
    div.form {
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #f0f0f0;
    }
    button {
        padding: 5px 10px;
    }
</style>
