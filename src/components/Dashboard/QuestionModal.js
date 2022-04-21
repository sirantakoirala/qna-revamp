import { doc, getDoc, serverTimestamp } from "firebase/firestore";
import React, { useState, useEffect } from "react";
import {
  Button,
  Header,
  Modal,
  Select,
  Form,
  Input,
  TextArea,
} from "semantic-ui-react";
import { collection, query, where, getDocs, addDoc } from "firebase/firestore";
import { db } from "../../firebase-config";
import { useUserContext } from "../../context/userContext";
import { v4 as uuidv4 } from "uuid";

const initialState = {
  topicTitle: "",
  topicSubject: "",
  topicDescription: "",
};
export function QuestionModal({ subjectOptions }) {
  const [open, setOpen] = React.useState(false);

  const { currentUser } = useUserContext();

  const [formState, setFormState] = useState(initialState);
  const handleChange = (ev) => {
    setFormState((prev) => ({ ...prev, [ev.target.id]: ev.target.value }));
  };

  const handleTopicSubmit = async (ev) => {
    ev.preventDefault();
    console.log(formState);
    try {
      if (
        formState.topicDescription === "" ||
        formState.topicSubject === "" ||
        formState.topicTitle === ""
      ) {
        return;
      }
      const topicCollRef = collection(db, "topics");
      const subjectCollRef = collection(db, "subject");
      await addDoc(topicCollRef, {
        ...formState,
        user: currentUser.email,
        topicId: uuidv4(),
        createdAt: serverTimestamp(),
      });
      setOpen(false);
      setFormState(initialState);
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <Modal
      onClose={() => setOpen(false)}
      onOpen={() => setOpen(true)}
      open={open}
      trigger={<Button>Create Post</Button>}
    >
      <Modal.Header>Topic</Modal.Header>
      <Modal.Content>
        <Modal.Description>
          <Header>Add a topic</Header>
          <Form onSubmit={handleTopicSubmit}>
            <Form.Group>
              <Form.Field
                control={Input}
                label="Topic title"
                placeholder="Add a topic"
                id="topicTitle"
                value={formState.topicTitle}
                onChange={handleChange}
              />
            </Form.Group>

            <Form.Field
              control={Select}
              label="Topic Subject"
              options={subjectOptions}
              placeholder="Subject"
              id="topicSubject"
              onChange={(ev, data) => {
                setFormState((prev) => ({ ...prev, topicSubject: data.value }));
              }}
              value={formState.topicSubject}
            />
            <Form.Field
              control={TextArea}
              label="Topic Description"
              id="topicDescription"
              placeholder="Add a topic description"
              onChange={handleChange}
              value={formState.topicDescription}
            />

            <Form.Field control={Button}>Submit</Form.Field>
          </Form>
        </Modal.Description>
      </Modal.Content>
    </Modal>
  );
}
