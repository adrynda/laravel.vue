<template>
    <div class="mx-[30%] mt-[2%]">
      <Search @search="loadItems" />
       <div>
            <a href="todo/create">Dodaj</a>
       </div>
      <ul>
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
                items: []
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
        },
        mounted() {
            this.loadItems();
        }
    }
</script>

<style scoped>
    ul {
        background-color: #f9f9f9;
        padding: 10px;
        list-style-type: none;
        margin: 0px;
    }
</style>
