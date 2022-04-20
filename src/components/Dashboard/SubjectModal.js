import React, { useState } from "react";
import { Button, Header, Modal, Form, Input } from "semantic-ui-react";
import { useUserContext } from "../../context/userContext";
import { db } from "../../firebase-config";

import { collection, addDoc } from "firebase/firestore";

export function SubjectModal() {
  const [open, setOpen] = React.useState(false);
  const [subject, setSubject] = useState("");
  const { currentUser } = useUserContext();
  const handleSubject = async (ev) => {
    ev.preventDefault();
    try {
      if (!subject) return;
      const subjectCollRef = collection(db, "subject");
      await addDoc(subjectCollRef, {
        title: subject,
        user: currentUser.uid,
      });
      setOpen(false);
    } catch (err) {
      console.log(err);
    }
  };
  return (
    <Modal
      onClose={() => setOpen(false)}
      onOpen={() => setOpen(true)}
      open={open}
      trigger={<Button>Create a Subject</Button>}
    >
      <Modal.Header>Subject</Modal.Header>
      <Modal.Content>
        <Modal.Description>
          <Header>Add a subject</Header>
          <Form onSubmit={handleSubject}>
            <Form.Group>
              <Form.Field
                control={Input}
                label="Subject Title"
                placeholder="Title...."
                onChange={(ev) => setSubject(ev.target.value)}
                value={subject}
              />
            </Form.Group>
            <Form.Field control={Button} type="submit">
              Submit
            </Form.Field>
          </Form>
        </Modal.Description>
      </Modal.Content>
    </Modal>
  );
}
