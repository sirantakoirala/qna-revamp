import React, { useState } from "react";
import {
  Button,
  Form,
  Grid,
  Header,
  Image,
  Message,
  Segment,
} from "semantic-ui-react";
import { useUserContext } from "../../context/userContext";
import AgoraLogo from "../../images/logo.png";
import { useNavigate } from "react-router-dom";

export const Login = () => {
  const [formState, setFormState] = useState({ email: "", password: "" });
  const { signIn } = useUserContext();
  const navigate = useNavigate();
  const handleChange = (ev) => {
    setFormState((prev) => ({ ...prev, [ev.target.id]: ev.target.value }));
  };

  const handleLogin = async (ev) => {
    ev.preventDefault();

    try {
      if (formState.email === "" || formState.password === "") return;
      await signIn(formState.email, formState.password);
      navigate("/dashboard");
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <>
      <Header as="h2" color="teal" textAlign="center">
        <Image src={AgoraLogo} />
        Agora
      </Header>
      <Form size="large" onSubmit={handleLogin}>
        <Segment stacked>
          <Form.Input
            fluid
            icon="user"
            iconPosition="left"
            placeholder="E-mail address"
            id="email"
            onChange={handleChange}
          />
          <Form.Input
            fluid
            icon="lock"
            iconPosition="left"
            placeholder="Password"
            type="password"
            id="password"
            onChange={handleChange}
          />

          <Button color="teal" fluid size="large" type="submit">
            Login
          </Button>
        </Segment>
      </Form>
    </>
  );
};
