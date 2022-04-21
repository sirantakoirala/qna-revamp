import React, { useState } from "react";
import {
  Button,
  Form,
  Header,
  Image,
  Loader,
  Dimmer,
  Message,
  Segment,
} from "semantic-ui-react";
import AgoraLogo from "../../images/logo3.png";
import { useUserContext } from "../../context/userContext";
import { addDoc, collection } from "firebase/firestore";
import { db } from "../../firebase-config";

const initialState = {
  email: "",
  password: "",
  confirmPassword: "",
};

const setUpUserRoleOnSignUp = async (userId, email) => {
  const userCollRef = collection(db, "users");

  await addDoc(userCollRef, {
    role: "student",
    uid: userId,
    email: email,
  });
};

export const SignUp = () => {
  const [formState, setFormState] = useState(initialState);
  const { signUp, currentUser } = useUserContext();
  const handleChange = (ev) => {
    setFormState((prev) => ({ ...prev, [ev.target.id]: ev.target.value }));
  };
  const [isSignUpInProgress, setIsSignUpInProgress] = useState(false);
  const [isSuccess, setIsSuccess] = useState(false);
  const handleSignUp = async (ev) => {
    ev.preventDefault();
    if (
      formState.email === "" ||
      formState.password === "" ||
      formState.confirmPassword === ""
    ) {
      return;
    }
    if (formState.confirmPassword !== formState.password) {
      return;
    }

    if (formState.confirmPassword.length < 6 || formState.password.length < 6) {
      return;
    }
    setIsSignUpInProgress(true);
    const { user } = await signUp(formState.email, formState.password);
    await setUpUserRoleOnSignUp(user.uid, formState.email);
    setFormState(initialState);
    setIsSignUpInProgress(false);
    setIsSuccess(true);
  };
  return (
    <>
      <Image src={AgoraLogo} />

      {isSuccess && (
        <Message
          success
          header="Your user registration was successful"
          content="You may now log-in with the username you have chosen"
        />
      )}

      <Form size="large" onSubmit={handleSignUp}>
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
            onChange={handleChange}
            id="password"
          />
          <Form.Input
            fluid
            icon="lock"
            iconPosition="left"
            placeholder="Confirm Password"
            onChange={handleChange}
            type="password"
            id="confirmPassword"
          />

          <Button color="teal" fluid size="large" type="submit">
            {isSignUpInProgress ? (
              <Dimmer active>
                <Loader size="mini">Loading</Loader>
              </Dimmer>
            ) : (
              "Sign up"
            )}
          </Button>
        </Segment>
      </Form>
    </>
  );
};
