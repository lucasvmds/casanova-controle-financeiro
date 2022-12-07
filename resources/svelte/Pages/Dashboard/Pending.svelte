<script lang="ts">
    import { Transaction } from "../../../ts/types";
    import { makeDate } from "../../../ts/support";
    import Type from "../Transaction/Type.svelte";
    export let transactions: Transaction[];
</script>

<article>
    <h2>Transações pendentes</h2>
    {#if !transactions}
        <p>Carregando dados...</p>
    {:else}
        <table class="center">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Segmento</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Tipo</th>
                    <th>Data validação</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                {#each transactions as transaction}
                    <tr>
                        <td>{transaction.group_id || '-'}</td>
                        <td>{transaction.segment_name}</td>
                        <td>{transaction.description}</td>
                        <td>{transaction.amount}</td>
                        <td>
                            <Type type={transaction.type} />
                        </td>
                        <td>{makeDate(transaction.valid_at).format('d/m/Y', true)}</td>
                        <td>{makeDate(transaction.created_at).format('d/m/Y H:i')}</td>
                    </tr>
                {:else}
                    <tr>
                        <td colspan="7">Não foram encontrados registros no momento</td>
                    </tr>
                {/each}
            </tbody>
        </table>
    {/if}
</article>