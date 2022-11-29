<script lang="ts">
    type Data = {
        email: string;
        password: string;
        remember: boolean;
    }

    import { Input, SelectionBox, Errors } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import FlashMessages from "../../Base/FlashMessages.svelte";
    export let errors: Errors<Data>;
    
    const DATA: Data = {
        email: '',
        password: '',
        remember: false,
    }

    function handleSubmit(): void
    {
        Inertia.post('session', DATA, {
            preserveScroll: true,
        });
    }
</script>

<main id="login-page">
    <h1>Login</h1>
    <form on:submit|preventDefault={handleSubmit} id="form-login">
        <Input type="email" label="E-Mail" bind:value={DATA.email} error={errors.email} required />
        <br />
        <Input type="password" label="Senha" bind:value={DATA.password} error={errors.password} required />
        <br />
        <SelectionBox type="checkbox" label="Manter conectado" bind:checked={DATA.remember} error={errors.remember} />
        <br />
        <button type="submit">
            Acessar
        </button>
    </form>
</main>

<FlashMessages />