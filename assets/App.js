import "./styles/App.css";
import React from 'react';
import { useState } from "react";
import Alert from "@mui/material/Alert";
import Button from "@mui/material/Button";
import TextField from "@mui/material/TextField";

const App = () => {
    const [errorMsg, setErrorMsg] = useState("");
    const [displayValue, setDisplayValue] = useState(0);
    const [firstNumber, setFirstNumber] = useState(0);
    const [isLoading, setIsLoading] = useState(false);
    const [operand, setOperand] = useState(null);
    const selectOperation = (requestedOperand) => {
        if (!operand) {
            setFirstNumber(displayValue);
            setOperand(requestedOperand);
            return;
        }

        setErrorMsg("");
        setIsLoading(true);
        fetch(
            `http://localhost:8080/calculate/${firstNumber}/${operand}/${displayValue}`
        )
            .then((res) => res.json())
            .then(
                ({ result, error }) => {
                    if (error) {
                        setErrorMsg(error);
                        return;
                    }
                    setOperand(null);
                    setFirstNumber(result);
                    setDisplayValue(result);
                },
                ({ message }) => {
                    setErrorMsg(message);
                }
            )
            .then(() => setIsLoading(false));
    };
    return (
        <div className="App">
            <div className="calculator">
                {errorMsg && <Alert severity="error">{errorMsg}</Alert>}
                <Button
                    onClick={() => {
                        setErrorMsg("");
                        setFirstNumber(0);
                        setDisplayValue(0);
                        setOperand(null);
                    }}
                    variant="outlined"
                    disabled={isLoading}
                >
                    Clear
                </Button>
                <TextField
                    disabled={isLoading}
                    id="outlined-number"
                    type="number"
                    value={isLoading ? "Calculating..." : displayValue}
                    onChange={({ target: { value } }) => setDisplayValue(value)}
                />
                <div>
                    <Button
                        variant="outlined"
                        onClick={() => selectOperation("add")}
                        disabled={isLoading}
                    >
                        +
                    </Button>
                    <Button
                        variant="outlined"
                        onClick={() => selectOperation("subtract")}
                        disabled={isLoading}
                    >
                        -
                    </Button>
                    <Button
                        variant="outlined"
                        onClick={() => selectOperation("multiply")}
                        disabled={isLoading}
                    >
                        *
                    </Button>
                    <Button
                        variant="outlined"
                        onClick={() => selectOperation("divide")}
                        disabled={isLoading}
                    >
                        /
                    </Button>
                    <Button
                        variant="contained"
                        onClick={() => {
                            if (operand) {
                                setDisplayValue(0);
                                selectOperation(null);
                            }
                        }}
                        disabled={isLoading}
                    >
                        =
                    </Button>
                </div>
            </div>
        </div>
    );
};

export default App;
