<template>
    <div class="content">
        <ul class="list-box">
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
        <div class="list-box-aside">
            <div class="list-box-aside-item secondary-bg-color">
                <a href="todo/create" class="btn btn-add">
                    Dodaj
                </a>
                <button @click="toggleShowFilters" class="btn btn-main">
                    {{ showFilters ? 'Ukryj filtry' : 'Pokaż filtry' }}
                </button>

            </div>
            <Search v-if="showFilters" class="list-box-aside-item secondary-bg-color" @search="loadItems" />
        </div>
    </div>
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
