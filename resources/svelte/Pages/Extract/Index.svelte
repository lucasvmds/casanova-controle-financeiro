<script lang="ts">
    type Data = {
        initial_date: string;
        final_date: string;
    }
    
    import { Segment } from "../../../ts/types";
    import { Input, Select, Errors } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    export let
        segments: Segment[],
        errors: Errors<Data>;
            
    let segment_id = '';
    const DATA: Data = {
        initial_date: null,
        final_date: null,
    }

    function listTransactions(): void
    {
        const TEMP: Data = {
            initial_date: `${DATA.initial_date}T00:00:00.000Z`,
            final_date: `${DATA.final_date}T23:59:59.000Z`,
        }
        Inertia.get(`/extracts/${segment_id}`, TEMP, {
            preserveScroll: true,
        });
    }
</script>

<main>
    <h1>Extratos</h1>
    <form id="form-extract" on:submit|preventDefault={listTransactions}>
        <Input type="date" label="Data inicial" bind:value={DATA.initial_date} error={errors.initial_date} required />
        <Input type="date" label="Data final" bind:value={DATA.final_date} error={errors.final_date} required />
        <br />
        <Select label="Segmento" bind:value={segment_id} error="" blank required>
            {#each segments as segment}
                <option value="{segment.id}">{segment.name}</option>
            {/each}
        </Select>
    </form>
</main>

<aside>
    <button type="submit" form="form-extract">
        Gerar extrato
    </button>
</aside>