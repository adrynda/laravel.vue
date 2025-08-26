<template>
    <div class="mx-[30%] mt-[2%]">
      <Form @add="addItem" />
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
    import Form from './Form.vue';
    import Item from './Item.vue';
    import axios from "axios";

    export default {
        components: {
            Form,
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
            addItem(newItem) {
                axios
                    .post('todo/create', newItem)
                    .then((response)  => {
                        newItem.id = response.data.id;
                        newItem.createdAt = new Date(response.data.createdAt);
                        this.items.push(newItem);
                    })
                ;
            },
            loadItems(items) {
                items.forEach(item => {
                    item.createdAt = new Date(item.createdAt);
                    item.dueDate = new Date(item.dueDate);
                    this.items.push(item);
                });
            },
            getItems() {
                axios
                    .get('todo/list')
                    .then(response => (this.loadItems(response.data)))
                ;
            }
        },
        mounted() {
            this.getItems();
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
