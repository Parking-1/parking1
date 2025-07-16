import { GET_TARIFAS, GET_TARIFAS_ERROR } from "./actions";

const initialState = {
  tarifas: [],
  error: null,
};

const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_TARIFAS:
      return {
        ...state,
        tarifas: action.payload,
        error: null,
      };

    case GET_TARIFAS_ERROR:
      return {
        ...state,
        error: action.payload,
      };

    default:
      return state;
  }
};

export default rootReducer;
