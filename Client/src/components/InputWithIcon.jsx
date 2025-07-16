// src/components/InputWithIcon.jsx

import PropTypes from "prop-types";

const InputWithIcon = ({
  icon: Icon,
  type = "text",
  placeholder,
  value,
  onChange,
  showToggle = false,
  showPassword,
  onTogglePassword,
  id,
}) => {
  const inputType = showToggle && !showPassword ? "password" : type;

  return (
    <div className="relative flex items-center">
      {Icon && (
        <Icon className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
      )}
      <input
        id={id}
        type={inputType}
        className="w-full border border-gray-200 outline-none py-2 pl-8 pr-10 rounded-lg text-sm"
        placeholder={placeholder}
        value={value}
        onChange={onChange}
        autoComplete="off"
        required
      />
      {showToggle && (
        <button
          type="button"
          onClick={onTogglePassword}
          className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:cursor-pointer"
          aria-label={
            showPassword ? "Ocultar contraseña" : "Mostrar contraseña"
          }
        >
          {showPassword ? (
            // Ícono de ojo cerrado
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              width={20}
              height={20}
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10a9.956 9.956 0 011.175-4.825m6.176-.049A4 4 0 1116.95 9.95"
              />
            </svg>
          ) : (
            // Ícono de ojo abierto
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              width={20}
              height={20}
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm2.121 2.121A5.988 5.988 0 0018 12c0-1.657-.672-3.157-1.758-4.242"
              />
            </svg>
          )}
        </button>
      )}
    </div>
  );
};

InputWithIcon.propTypes = {
  icon: PropTypes.elementType.isRequired,
  type: PropTypes.string,
  placeholder: PropTypes.string,
  value: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
  onChange: PropTypes.func,
  showToggle: PropTypes.bool,
  showPassword: PropTypes.bool,
  onTogglePassword: PropTypes.func,
  id: PropTypes.string,
};

export default InputWithIcon;
