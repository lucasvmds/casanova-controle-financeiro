<script lang="ts">
    import { TransactionSearchStore } from "../../../../ts/stores/transaction_search";

    function toggleSearch(): void
    {
        TransactionSearchStore.set(
            !($TransactionSearchStore)
        );
    }
</script>

<button type="button" on:click={toggleSearch}>
    {$TransactionSearchStore ? 'Fechar pesquisa' : 'Abrir pesquisa'}
</button>