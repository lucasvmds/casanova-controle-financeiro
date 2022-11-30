<script lang="ts">    
    type User = {
        id: number;
        email: string;
    }

    type Data = {
        email: string;
        current_password: string;
        password: string;
        password_confirmation: string;
    }
    
    import { Inertia } from "@inertiajs/inertia";
    import { Input, Errors } from "../../Components/Form/index.svelte";
    export let
        user: User,
        errors: Errors<Data>;

    const DATA: Data = {
        email: user.email,
        current_password: '',
        password: '',
        password_confirmation: '',
    }

    function updateUser(): void
    {
        Inertia.patch('/session', DATA, {
            preserveScroll: true,
            onSuccess: () => {
                DATA.current_password = '';
                DATA.password = '';
                DATA.password_confirmation = '';
            }
        });
    }
</script>

<main>
    <h1>Dados de acesso</h1>
    <form id="form" on:submit|preventDefault={updateUser}>
        <Input type="email" label="E-Mail" bind:value={DATA.email} error={errors.email} required />
        <Input type="password" label="Senha atual" bind:value={DATA.current_password} error={errors.current_password} />
        <br />
        <Input type="password" label="Nova senha" bind:value={DATA.password} error={errors.password} />
        <Input type="password" label="Confirmar senha" bind:value={DATA.password_confirmation} error={errors.password_confirmation} />
    </form>
</main>

<aside>
    <button type="submit" form="form">
        Salvar
    </button>
</aside>