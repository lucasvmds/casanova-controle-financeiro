<script lang="ts">
    import { Balance } from "../../../ts/types";
    export let balances: Balance[];
</script>

<article id="balances">
    <h2>Saldos</h2>
    {#if !balances}
        <p>Carregando dados...</p>
    {:else}
        <dl>
            {#each balances as balance}
                <div> 
                    <dt>
                        <b>{balance.segment_name}</b>
                    </dt>
                    <dd>{balance.amount}</dd>
                </div>
            {:else}
                <p>Nenhum segmento encontrado para mostrar o saldo</p>
            {/each}
        </dl>
    {/if}
</article>