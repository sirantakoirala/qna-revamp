import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { Sidebar } from "../Dashboard/Sidebar";
import { Button, Checkbox, Form, Card, Icon, Label } from "semantic-ui-react";
import { v4 as uuidv4 } from "uuid";
import {
  collection,
  query,
  where,
  getDocs,
  addDoc,
  serverTimestamp,
  onSnapshot,
  orderBy,
} from "firebase/firestore";
import { useUserContext } from "../../context/userContext";
import { db } from "../../firebase-config";
export const Topic = () => {
  const { topicId } = useParams();
  const { currentUser } = useUserContext();
  const [posts, setPosts] = useState([]);
  const [formState, setFormState] = useState("");
  const [topic, setTopic] = useState({});

  useEffect(() => {
    async function getTopic() {
      try {
        const q = query(
          collection(db, "topics"),
          where("topicId", "==", topicId)
        );

        const querySnapshot = await getDocs(q);
        const [topic] = querySnapshot.docs.map((post) => post.data());
        setTopic(topic);
      } catch (err) {
        console.log(err);
      }
    }
    getTopic();
  }, []);

  useEffect(() => {
    async function getPosts() {
      try {
        const q = query(
          collection(db, "posts"),
          where("topicId", "==", topicId)
        );

        const unsub = await onSnapshot(q, (querySnapshot) => {
          const posts = querySnapshot.docs
            .map((post) => post.data())
            .sort((a, b) => a.createdAt - b.createdAt);
          setPosts(posts);
        });

        return unsub;
      } catch (err) {
        console.log(err);
      }
    }
    return getPosts();
  }, []);
  const handlePost = async (ev) => {
    ev.preventDefault();
    try {
      if (formState === "") {
        return;
      }
      const postCollRef = collection(db, "posts");
      await addDoc(postCollRef, {
        postTitle: formState,
        user: currentUser.email,
        uid: currentUser.uid,
        topicId: topicId,
        postId: uuidv4(),
        createdAt: serverTimestamp(),
      });
      console.log("here");
    } catch (err) {
      console.log(err);
    }
  };
  return (
    <Sidebar>
      <Card style={{ width: "100%" }}>
        <Card.Content style={{ width: "100% !important" }}>
          <Card.Header>{topic.topicTitle}</Card.Header>
          <Card.Meta>{topic.topicSubject}</Card.Meta>
          <Card.Description>{topic.topicDescription}</Card.Description>
          <Label>{topic.user}</Label>
        </Card.Content>
      </Card>
      <Form onSubmit={handlePost}>
        <Form.Field>
          <input
            value={formState}
            placeholder="Add a post"
            onChange={(ev) => {
              setFormState(ev.target.value);
            }}
          />
        </Form.Field>

        <Button type="submit">Submit</Button>
      </Form>
      <h1>Posts</h1>
      {posts.map((post) => (
        <Card
          header={post.postTitle}
          extra={
            <a>
              <Icon name="user" />
              {post.user}
            </a>
          }
        />
      ))}
    </Sidebar>
  );
};
