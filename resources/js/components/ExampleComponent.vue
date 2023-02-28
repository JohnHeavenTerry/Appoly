<template>
    <EasyDataTable
        show-index
        buttons-pagination
        :headers="headers"
        :items="items"
        :loading="loading"
    >
        <template #loading>
            <img
                src="https://media.tenor.com/Qf0Hko0fZWQAAAAC/pokemon-pokeball.gif"
                style="width: 300px; height: 200px"
            />
        </template>
    </EasyDataTable>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from "vue";
import { Header, Item } from "vue3-easy-data-table";

export default defineComponent({
    data() {
        return {
        }
    },
    components: {},
    props: ['pokeData'],
    setup(props) {

        const headers: Header[] = [
            { text: "Name", value: "pokemon.name" },
            { text: "HP", value: "pokemon.hp" },
            { text: "Attack", value: "pokemon.attack" },
            { text: "Defense", value: "pokemon.defense" },
            { text: "Special Attack", value: "pokemon.special-attack" },
            { text: "Special Defense", value: "pokemon.special-defense", sortable: true },
            { text: "Speed", value: "pokemon.speed" },
            { text: "Height", value: "pokemon.height" },
            { text: "Weight", value: "pokemon.weight" },
        ];

        const itemsSelected: Item[] = ref([]);
        const items: Item[] = ref([]);
        const loading = ref(true);

        setTimeout(() => {
            loading.value = false;
        }, 2000);

        items.value = [
            props.pokeData,
        ];

        return {
            loading,
            headers,
            items,
        };
    },
    methods:{

    },
    created() {
    }
});

</script>

<style>
.operation-wrapper .operation-icon {
    width: 20px;
    cursor: pointer;
}
.player-wrapper {
    padding: 5px;
    display: flex;
    align-items: center;
    justify-items: center;
}
.avator {
    margin-right: 10px;
    display: inline-block;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 10%);
}
</style>
