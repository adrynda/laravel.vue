<template>
    <div class="border-b border-white/10 pb-12 bg-orange-50 p-4 rounded-xl space-x-2 space-y-2">
        <div
            class="flex flex-wrap gap-4 mb-4"
        >
            <InputTextField
                class="w-[32%]"
                label="Tytuł"
                placeholder="Tytuł"
                ref="titleField"
                v-model="query.title"
            />
            <InputDatetimeField
                class="w-[32%]"
                label="Data realizacji"
                ref="dueDateField"
                v-model="query.dueDate"
            />
            <SelectField
                class="w-[32%]"
                label="Użytkownik"
                placeholder="Użytkownik"
                :options="users"
                ref="userField"
                v-model="query.user"
            />
            <SelectField
                class="w-[32%]"
                label="Priorytet"
                placeholder="Priorytet"
                :options="priorities"
                ref="priorityField"
                v-model="query.priority"
            />
            <SelectField
                class="w-[32%]"
                label="Kategoria"
                placeholder="Kategoria"
                :options="categories"
                ref="categoryField"
                v-model="query.category"
            />
            <SelectField
                class="w-[32%]"
                label="Statusy"
                placeholder="Statusy"
                :options="statuses"
                ref="statusField"
                v-model="query.status"
            />
            <TextareaField
                class="w-[32%]"
                label="Notatki"
                placeholder="Notatki"
                ref="notesField"
                v-model="query.notes"
            />
        </div>
        <button
            @click="submit"
            class="inline-flex items-center justify-center cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
            Szukaj
        </button>
        <button
            @click="clear"
            class="inline-flex items-center justify-center cursor-pointer bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
        >
            Wyczyść
        </button>
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
