import { createStore, applyMiddleware, compose } from "redux";
import thunk from "redux-thunk"; // ✅ Importación correcta
import rootReducer from "./reducer"; // ✅ Asegúrate de que la ruta sea correcta

const composeEnhancer = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const store = createStore(rootReducer, composeEnhancer(applyMiddleware(thunk)));

export default store;
