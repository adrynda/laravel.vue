<template>
    <div class="form">
        <InputTextField
            label="Tytuł"
            placeholder="Tytuł"
            ref="titleField"
            v-model="query.title"
        />
        <InputDatetimeField
            label="Data realizacji"
            ref="dueDateField"
            v-model="query.dueDate"
        />
        <SelectField
            label="Użytkownik"
            placeholder="Użytkownik"
            :options="users"
            ref="userField"
            v-model="query.user"
        />
        <SelectField
            label="Priorytet"
            placeholder="Priorytet"
            :options="priorities"
            ref="priorityField"
            v-model="query.priority"
        />
        <SelectField
            label="Kategoria"
            placeholder="Kategoria"
            :options="categories"
            ref="categoryField"
            v-model="query.category"
        />
        <SelectField
            label="Statusy"
            placeholder="Statusy"
            :options="statuses"
            ref="statusField"
            v-model="query.status"
        />
        <TextareaField
            label="Notatki"
            placeholder="Notatki"
            ref="notesField"
            v-model="query.notes"
        />
        <button @click="submit">Szukaj</button>
        <button @click="clear">Wyczyść</button>
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
        data() {
            return {
                query: {
                    dueDate: null,
                    title: null,
                    priority: null,
                    category: null,
                    status: null,
                    notes: null,
                    user: null,
                },

                categories: [],
                priorities: [],
                statuses: [],
                users: [],
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
                            this.categories.push({ value: cat.id, label: cat.name });
                        });
                    })
            },
            loadStatuses() {
                axios
                    .get('/api/to_do_statuses')
                    .then(response => {
                        this.statuses = []
                        response.data.forEach(stat => {
                            this.statuses.push({ value: stat.id, label: stat.name });
                        });
                    })
            },
            loadUsers() {
                axios
                    .get('/api/users')
                    .then(response => {
                        this.users = []
                        response.data.forEach(user => {
                            this.users.push({ value: user.id, label: user.name });
                        });
                    })
            },
            submit() {
                let query = this.query;
                this.$emit('search', query);
            },
            clear() {
                this.query = {
                    dueDate: null,
                    title: null,
                    priority: null,
                    category: null,
                    status: null,
                    notes: null,
                    user: null,
                };
                this.submit();
            }
        },
        mounted() {
            this.loadPriorities();
            this.loadCategories();
            this.loadStatuses();
            this.loadUsers();
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
