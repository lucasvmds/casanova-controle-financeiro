<script lang="ts">
    type Data = {
        search: string;
        segment_id: string;
    }

    import { Input, Select } from "../../../Components/Form/index.svelte";
    import { TransactionSearchStore } from "../../../../ts/stores/transaction_search";
    import { Inertia } from "@inertiajs/inertia";
    import { Segment } from "../../../../ts/types";
    export let segments: Segment[];

    const DATA: Data =  {
        search: null,
        segment_id: '',
    }

    function filterTransactions(): void
    {
        Inertia.get(location.pathname, DATA, {
            preserveScroll: true,
        });
    }

    $: {
        if (!$TransactionSearchStore && DATA.search) {
            DATA.search = null;
            DATA.segment_id = '';
            filterTransactions();
        }
    }
</script>

{#if $TransactionSearchStore}
    <form id="transactions-search" on:submit|preventDefault={filterTransactions}>
        <fieldset>
            <legend>Filtrar transações</legend>
            <Input type="search" label="Pesquise pelo código interno ou descrição" bind:value={DATA.search} error="" size="40" />
            <Select label="Segmento" bind:value={DATA.segment_id} error="" blank>
                {#each segments as segment}
                    <option value="{segment.id}">{segment.name}</option>
                {/each}
            </Select>
        </fieldset>
    </form>
{/if}