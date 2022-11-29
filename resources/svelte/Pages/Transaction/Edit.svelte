<script lang="ts">
    type Data = {
        amount: number;
        pending: boolean;
        valid_at: string;
        created_at: string;
        description: string;
    }

    import { Link } from "@inertiajs/inertia-svelte";
    import { Input, TextArea, SelectionBox, Errors } from "../../Components/Form/index.svelte";
    import { Transaction } from "../../../ts/types";
    import { Inertia } from "@inertiajs/inertia";
    import { DateFormat, makeDate } from "../../../ts/support";
    import Type from "./Type.svelte";
    export let
        transaction: Transaction,
        errors: Errors<Data>;

    const DATA: Data = {
        amount: parseFloat(
                    transaction.amount
                        .replace(/\D/g, '')
                        .replace(/^(\d+)(\d{2}$)/, '$1.$2')
                ),
        pending: transaction.pending,
        valid_at: makeDate(transaction.valid_at).format('Y-m-d', true),
        created_at: makeDate(transaction.created_at).format('Y-m-d H:i'),
        description: transaction.description,
    }

    function createTransaction(): void
    {
        const TEMP = {...DATA};
        if (TEMP.created_at)
            TEMP.created_at = DateFormat.iso(TEMP.created_at);
        Inertia.patch(`/transactions/${transaction.id}`, TEMP, {
            preserveScroll: true,
        });
    }
</script>

<main>
    <h1>Editar transação</h1>
    <table>
        <tbody>
            <tr>
                <td>
                    <b>Segmento: </b>
                    {transaction.segment_name}
                </td>
                <td>
                    <b>Tipo: </b>
                    <Type type={transaction.type} />
                </td>
                <td>
                    <b>Código interno: </b>
                    {transaction.group_id || '-'}
                </td>
            </tr>
        </tbody>
    </table>
    <br />
    <br />
    <form id="form-create-transaction" on:submit|preventDefault={createTransaction}>
        <Input type="number" label="Valor (R$)" bind:value={DATA.amount} error={errors.amount} step="0.01" required />
        <Input type="datetime-local" label="Data do lançamento" bind:value={DATA.created_at} error={errors.created_at} />
        <br />
        <SelectionBox type="checkbox" label="Pendente" bind:checked={DATA.pending} error={errors.pending} />
        {#if DATA.pending}
            <Input type="date" label="Data para validar" bind:value={DATA.valid_at} error={errors.valid_at} required />
        {/if}
        <br />
        <TextArea label="Descrição" bind:value={DATA.description} error={errors.description} rows="5" cols="60" required />
    </form>
</main>

<aside>
    <button type="submit" form="form-create-transaction">
        Salvar
    </button>
    <Link href="/transactions/pending">
        Voltar
    </Link>
</aside>