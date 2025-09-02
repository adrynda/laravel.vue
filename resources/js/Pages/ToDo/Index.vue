<template>
    <div class="mx-auto mt-4 w-[50%]">
        <a
            href="todo/create"
            class="inline-flex items-center justify-center cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
        >
            Dodaj
        </a>
        <button
            @click="toggleShowFilters"
            class="inline-flex items-center justify-center cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
            {{ showFilters ? 'Ukryj filtry' : 'Pokaż filtry' }}
        </button>
    </div>
    <Search v-if="showFilters" @search="loadItems" class="mx-auto mt-4 w-[50%]" />
    <ul class="mx-auto mt-4 w-[50%] border-b border-white/10 pb-12 bg-orange-50 p-4 rounded-xl space-x-2 space-y-2">
        <Item
            v-for="item in items"
            :key="item.id"
            :item="item"
            @remove="removeItem"
        />
        <li v-if="items.length === 0">
            Brak zadań do wykonania.
        </li>
    </ul>
</template>

<script>
    import Search from './Search.vue';
    import Item from './Item.vue';
    import axios from "axios";

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    export default {
        components: {
            Search,
            Item
        },
        data() {
            return {
                items: [],
                showFilters: true,
            }
        },
        methods: {
            removeItem(itemId) {
                this.items = this.items.filter(item => item.id !== itemId);
            },
            loadItems(query = {}) {
                this.items = [];
                
                axios
                    .get('api/to_dos', { params: query })
                    .then((response) => {
                        response.data.forEach(item => {
                            item.createdAt = new Date(item.createdAt);
                            item.updatedAt = new Date(item.updatedAt);
                            item.dueDate = new Date(item.dueDate);
                            this.items.push(item);
                        });
                    })
                ;
                
            },
            toggleShowFilters() {
                this.showFilters = !this.showFilters;
            }
        },
        mounted() {
            this.loadItems();
        }
    }
</script>
