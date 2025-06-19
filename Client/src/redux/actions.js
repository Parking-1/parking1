import axios from "axios";

export const GET_TARIFAS = "GET_TARIFAS";
export const GET_TARIFAS_ERROR = "GET_TARIFAS_ERROR";

export const getTarifas = () => {
  return async function (dispatch) {
    try {
      const response = await axios.get("http://localhost:8000/api/tarifa");
      dispatch({
        type: GET_TARIFAS,
        payload: response.data,
      });
    } catch (error) {
      console.error("Error al obtener las tarifas:", error);
      dispatch({
        type: GET_TARIFAS_ERROR,
        payload: error.message,
      });
    }
  };
};
