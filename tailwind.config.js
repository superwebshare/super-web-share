module.exports = {
  content: ["./admin/**/*.{php,js}"],
  theme: {
    extend: {
      screens: {
        xs: "390px",
        sm: "576px",
      },
    },
  },
  plugins: [require("tailwindcss"), require("autoprefixer")],
};
