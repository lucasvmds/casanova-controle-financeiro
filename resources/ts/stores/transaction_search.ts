import { writable } from "svelte/store";

const STORE = writable<boolean>(false);
export { STORE as  TransactionSearchStore };