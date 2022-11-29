<script lang="ts">
    import { TransactionType } from "../../../ts/types";
    export let type: TransactionType;

    const NAMES = {
        in: 'Entrada',
        out: 'Saída',
    }
</script>

<b class="transaction-type {type}">
    {NAMES[type]}
</b>