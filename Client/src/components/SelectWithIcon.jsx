// src/components/SelectWithIcon.jsx

import PropTypes from "prop-types";

const SelectWithIcon = ({
  icon: Icon,
  value,
  onChange,
  options,
  id,
  name,
  placeholder,
}) => {
  return (
    <div className="relative flex items-center">
      <Icon className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
      <select
        id={id}
        name={name}
        value={value}
        onChange={onChange}
        className="w-full border border-gray-200 outline-none py-2 pl-8 pr-4 rounded-lg text-sm appearance-none"
      >
        {placeholder && (
          <option value="" disabled hidden>
            {placeholder}
          </option>
        )}
        {options.map((opt) => (
          <option key={opt.value} value={opt.value}>
            {opt.label}
          </option>
        ))}
      </select>
    </div>
  );
};

SelectWithIcon.propTypes = {
  icon: PropTypes.elementType.isRequired,
  value: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
  onChange: PropTypes.func.isRequired,
  options: PropTypes.arrayOf(
    PropTypes.shape({
      value: PropTypes.oneOfType([PropTypes.string, PropTypes.number])
        .isRequired,
      label: PropTypes.string.isRequired,
    })
  ).isRequired,
  id: PropTypes.string,
  name: PropTypes.string,
  placeholder: PropTypes.string, // como "Selecciona una opción"
};

export default SelectWithIcon;
