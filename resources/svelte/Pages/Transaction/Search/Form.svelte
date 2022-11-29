<script lang="ts">
    import { Input } from "../../../Components/Form/index.svelte";
    import { TransactionSearchStore } from "../../../../ts/stores/transaction_search";
    import { Inertia } from "@inertiajs/inertia";

    let search: string = null;

    function filterTransactions(): void
    {
        let url = location.pathname + (search ? `?search=${search}` : '');
        Inertia.get(url, {}, {
            preserveScroll: true,
        });
    }

    $: {
        if (!$TransactionSearchStore && search) {
            search = null;
            filterTransactions();
        }
    }
</script>

{#if $TransactionSearchStore}
    <form id="transactions-search" on:submit|preventDefault={filterTransactions}>
        <fieldset>
            <legend>Filtrar transações</legend>
            <Input type="search" label="Pesquise pelo código interno ou descrição" bind:value={search} error="" size="40" />
        </fieldset>
    </form>
{/if}