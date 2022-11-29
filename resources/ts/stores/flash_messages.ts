import { writable } from "svelte/store";
import { FlashMessage } from "../types";

const STORE = writable<FlashMessage[]>([]);
export { STORE as FlashMessagesStore }