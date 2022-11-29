<script lang="ts">
    type Data = {
        segment_id: string;
        group_id: string;
        type: TransactionType;
        amount: number;
        pending: boolean;
        valid_at: string;
        description: string;
        created_at: string;
    }

    import { Link } from "@inertiajs/inertia-svelte";
    import { Select, Input, TextArea, SelectionBox, Errors } from "../../Components/Form/index.svelte";
    import { Segment, TransactionType } from "../../../ts/types";
    import { Inertia } from "@inertiajs/inertia";
    import { DateFormat } from "../../../ts/support";
    export let
        segments: Segment[],
        errors: Errors<Data>;

    const DATA: Data = {
        segment_id: '',
        group_id: null,
        type: null,
        amount: null,
        pending: false,
        valid_at: null,
        created_at: null,
        description: null,
    }

    function createTransaction(): void
    {
        const TEMP = {...DATA};
        if (TEMP.created_at)
            TEMP.created_at = DateFormat.iso(TEMP.created_at);
        Inertia.post('/transactions', TEMP, {
            preserveScroll: true,
            onSuccess: resetForm,
        });
    }

    function resetForm(): void
    {
        DATA.amount = null;
        DATA.created_at = null;
        DATA.description = null;
        DATA.pending = false;
        DATA.type = null;
        DATA.valid_at = null;
    }
</script>

<main>
    <h1>Adicionar transação</h1>
    <form id="form-create-transaction" on:submit|preventDefault={createTransaction}>
        <SelectionBox type="radio" label="Entrada" value="in" bind:selected={DATA.type} name="type" error={errors.type} required />
        <SelectionBox type="radio" label="Saída" value="out" bind:selected={DATA.type} name="type" error="" />
        <br />
        <Select label="Segmento" bind:value={DATA.segment_id} error={errors.segment_id} blank required>
            {#each segments as segmennt}
                <option value={segmennt.id}>{segmennt.name}</option>
            {/each}
        </Select>
        <br />
        <Input type="text" label="Código interno" bind:value={DATA.group_id} error={errors.group_id} />
        <br />
        <Input type="number" label="Valor (R$)" bind:value={DATA.amount} error={errors.amount} step=".01" required />
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
    <Link href="/transactions">
        Voltar
    </Link>
</aside>