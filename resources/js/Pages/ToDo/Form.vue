<template>
    <div class="form">
        <InputTextField
            label="Tytuł"
            placeholder="Tytuł"
            :assertion="{ regex: /^.{3,}$/, message: 'Minimum 3 znaki' }"
            ref="titleField"
            v-model="item.title"
            @validation="fieldValid.title = $event"
        />
        <InputDatetimeField
            label="Data realizacji"
            ref="dueDateField"
            v-model="item.dueDate"
            @validation="fieldValid.dueDate = $event"
        />
        <SelectField
            label="Priorytet"
            placeholder="Priorytet"
            :options="priorities"
            ref="priorityField"
            :assertion="{ regex: /^.{1,}$/, message: 'Pole nie może być puste' }"
            v-model="item.priority"
            @validation="fieldValid.priority = $event"
        />
        <SelectField
            label="Kategoria"
            placeholder="Kategoria"
            :options="categories"
            ref="categoryField"
            :assertion="{ regex: /^.{1,}$/, message: 'Pole nie może być puste' }"
            v-model="item.category"
            @validation="fieldValid.category = $event"
        />
        <SelectField
            label="Statusy"
            placeholder="Statusy"
            :options="statuses"
            ref="statusField"
            :assertion="{ regex: /^.{1,}$/, message: 'Pole nie może być puste' }"
            v-model="item.status"
            @validation="fieldValid.status = $event"
        />
        <TextareaField
            label="Notatki"
            placeholder="Notatki"
            :assertion="{ regex: /^.{1,}$/, message: 'Pole nie może być puste' }"
            ref="notesField"
            v-model="item.notes"
            @validation="fieldValid.notes = $event"
        />
        <button @click="submit">Zapisz</button>
        <a href="/todo">Wróć</a>
    </div>
</template>

<script>
    import InputTextField from '../../Components/FormFields/InputTextField.vue';
    import InputDatetimeField from '../../Components/FormFields/InputDatetimeField.vue';
    import SelectField from '../../Components/FormFields/SelectField.vue';
    import TextareaField from '../../Components/FormFields/TextareaField.vue';
    import axios from 'axios';



    export default {
        components: {
            InputTextField,
            InputDatetimeField,
            SelectField,
            TextareaField,
        },
        props: {
            user: Object,
            id: [Number, null],
        },
        data() {
            return {
                item: {
                    dueDate: null,
                    title: null,
                    priority: null,
                    category: null,
                    status: null,
                    notes: null,
                    user: `/api/users/${this.user.id}`,
                },
                fieldValid: {
                    title: false,
                    dueDate: false,
                    priority: false,
                    category: false,
                    status: false,
                    notes: false,
                },
                errors: [],
                categories: [],
                priorities: [],
                statuses: [],
            }
        },
        methods: {
            loadPriorities() {
                this.priorities = [
                    { value: 'low', label: 'Niski' },
                    { value: 'medium', label: 'Średni' },
                    { value: 'high', label: 'Wysoki' }
                ];
            },
            loadCategories() {
                axios
                    .get('/api/to_do_categories')
                    .then(response => {
                        this.categories = []
                        response.data.forEach(cat => {
                            this.categories.push({ value: `/api/to_do_categories/${cat.id}`, label: cat.name });
                        });
                    })
            },
            loadStatuses() {
                axios
                    .get('/api/to_do_statuses')
                    .then(response => {
                        this.statuses = []
                        response.data.forEach(stat => {
                            this.statuses.push({ value: `/api/to_do_statuses/${stat.id}`, label: stat.name });
                        });
                    })
            },
            loadItem() {
                if (!this.id) {
                    return;
                }
                axios
                    .get('/api/to_dos/' + this.id)
                    .then(response => {
                        this.item = response.data;
                    })
            },
            submit() {
                if (!this.isFormValid()) {
                    alert("Formularz zawiera błędy!");
                    return;
                }

                this.item.dueDate = new Date(this.item.dueDate);
                delete this.item.createdAt;
                delete this.item.updatedAt;
                delete this.item.id;

                if (this.id) {
                    this.update();
                } else {
                    this.create();
                }
            },
            isFormValid() {
                this.$refs.titleField.validate();
                this.$refs.dueDateField.validate();
                this.$refs.priorityField.validate();
                this.$refs.categoryField.validate();
                this.$refs.statusField.validate();
                this.$refs.notesField.validate();
                
                return Object.values(this.fieldValid).every(v => v === true);
            },
            create() {
                axios
                    .post('/api/to_dos', this.item)
                    .then((response)  => {
                        window.location.href = '/todo/edit/' + response.data.id;
                    })
                ;
            },
            update() {
                axios
                    .patch('/api/to_dos/' + this.id, this.item)
                    .then((response)  => {
                        window.location.reload();
                    })
                ;
            },
        },
        mounted() {
            this.loadPriorities();
            this.loadCategories();
            this.loadStatuses();
            this.loadItem();
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
