import { useState } from "react";
import "./App.css";
import axios from "axios";
type _t = {
  username: string;
  password: string;
};
function App() {
  const [input, setInput] = useState<_t>({} as _t);
  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    let el = e.target as HTMLInputElement;
    setInput({
      ...input,
      [el.name]: el.value,
    });
  };
  return (
    <div className="app">
      <form
        onSubmit={(e) => {
          e.preventDefault();
          axios.post("http://localhost:8080/", input).then((res) => {
            console.log(res);
          });
        }}
      >
        <input
          type="text"
          name="username"
          placeholder="username"
          onChange={handleChange}
        />
        <br />
        <input
          type="password"
          name="password"
          placeholder="password"
          onChange={handleChange}
        />
        <br />
        <button>Submit</button>
      </form>
    </div>
  );
}

export default App;
